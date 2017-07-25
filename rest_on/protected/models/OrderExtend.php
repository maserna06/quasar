<?php

class OrderExtend extends Order {

    public static function datos() {
        //$datos['increment'] = OrderExtend::largoInc($increment);
        $order = OrderConfig::model()->findByPk(OrderConfigExtend::ordenesCreate());
        if ($order) {
            $datos['orderConfig'] = $order;
            Yii::app()->getSession()->add('impresion', $datos['orderConfig']->order_format);
            Yii::app()->getSession()->add('warehouse', $datos['orderConfig']->wharehouse_id);
        }
        return $datos;
    }

    public function largoInc($value) {
        $large = strlen($value);
        if (5 - $large > 0)
            $value = str_repeat("0", 5 - $large) . $value;

        return $value;
    }

    public static function viewProducts() {

        $sql = Yii::app()->db->createCommand();
        $sql->select('c.category_id id, c.category_description name');
        $sql->from('tbl_products p');
        $sql->join('tbl_categories c', 'p.category_id = c.category_id');
        $sql->leftJoin('tbl_classification_product i', 'p.product_id = i.product_id');
        $sql->where('p.product_status = 1 ');
        $sql->andWhere('i.product_id IS NULL');
        $sql->andWhere('p.company_id = ' . Yii::app()->getSession()->get('empresa'));
        $sql->group('c.category_id');
        $categosrias = $sql->queryAll();

        $datos = array();
        $i = 0;
        foreach ($categosrias as $cat) {
            $datos[$i]['datos'] = $cat;
            $sql = Yii::app()->db->createCommand();
            $sql->select('p.*, u.unit_name unit_name');
            $sql->from('tbl_products p');
            $sql->leftJoin('tbl_classification_product i', 'p.product_id = i.product_id');
            $sql->join('tbl_unit u', 'p.unit_id = u.unit_id');
            $sql->where('p.product_status = 1 ');
            $sql->andWhere('i.product_id IS NULL');
            $sql->andWhere('p.category_id = ' . $cat['id']);
            $sql->andWhere('p.company_id = ' . Yii::app()->getSession()->get('empresa'));
            $sql->order('p.product_description');
            $prod = $sql->queryAll();
            for ($o = 0; $o < count($prod); $o++) {
                $tax = ProductsExtend::addProdTax($prod[$o]['product_id']);
                if ($tax > 0) {
                    $tax = 1 + ($tax / 100);
                    $prod[$o]['product_price'] = $prod[$o]['product_price'] * $tax;
                }
            }
            $datos[$i]['prod'] = $prod;
            $i++;
        }

//        echo '<pre>';
//        print_r($datos);exit;
        return $datos;
    }

    public static function saveOrder($id = NULL) {
        //echo '<pre>';
//        print_r($_POST);
//        exit;
        if (!$id) {
            $datos = OrderConfig::model()->findByPk(OrderConfigExtend::ordenesCreate());
            $model = new Order;
            $orderId = $datos->order_id + 1;
        } else {
            $model = Order::model()->findByPk($id);
            $orderId = $model->order_consecut;
        }
        $dis = $_POST['disSup'];
        $model->attributes = $_POST['Order'];
        $model->order_consecut = $orderId;
        $model->user_id = Yii::app()->user->id;
        $model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if ($model->save()) {
            if (!$id) {
                $datos->order_id = $orderId;
                $datos->save();
            }
            $obs = $model->order_remarks;
            $taxSupp = OrderExtend::taxSupp($model->supplier_nit);
            $productos = $_POST['product'];
            if ($id) {
                OrderExtend::deleteData($id);
            }
            foreach ($productos as $pro) {
                $precio = NULL;
                if ($pro['price'] == $pro['precioReal']) {
                    $taxProd = OrderExtend::taxProd($pro['prod']);
                    if ($taxProd)
                        $precio = Products::model()->findByPk($pro['prod'])->product_price;
                }
                $producto = new OrderDetails;
                $producto->order_id = $model->order_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_id = $pro['whare'];
                $producto->order_details_price = ($precio) ? $precio : $pro['price'];
                $producto->order_details_discount = ($dis) ? $pro['price'] * $pro['cant'] * $dis : 0;
                $producto->order_details_quantity = $pro['cant'];
                $producto->order_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                if ($producto->save()) {
                    if ($taxSupp) {
                        foreach ($taxSupp as $txsp) {
                            $taxSave = new OrderDetailsTaxes;
                            $taxSave->order_details_id = $producto->order_details_id;
                            $taxSave->taxes_id = $txsp['id'];
                            $taxSave->order_details_tax_value = $pro['price'] * $producto->order_details_quantity * $txsp['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                OrderExtend::deleteData($model->order_id);
                                Order::model()->deleteAll('order_id = ' . $model->order_id);
                                return 0;
                                }
                            }
                        }
                    }
                    if ($taxProd) {
                        foreach ($taxProd as $txpd) {
                            $taxSave = new OrderDetailsTaxes;
                            $taxSave->order_details_id = $producto->order_details_id;
                            $taxSave->taxes_id = $txpd['id'];
                            $taxSave->order_details_tax_value = $producto->order_details_price * $producto->order_details_quantity * $txpd['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                OrderExtend::deleteData($model->order_id);
                                Order::model()->deleteAll('order_id = ' . $model->order_id);
                                return 0;
                                }
                            }
                        }
                    }
                } else {
                    if (!$id) {
                        OrderExtend::deleteData($model->order_id);
                        Order::model()->deleteAll('order_id = ' . $model->order_id);
                        return 0;
                    }
                }
            }
            if ($_POST['send_mail'] == 'on') {
                OrderExtend::mailOrder($model);
            }
        } else {
            return 0;
        }
        return $model;
    }

    public static function deleteData($id) {
        $detail = OrderDetails::model()->findAll('order_id = ' . $id);
        foreach ($detail as $det) {
            OrderDetailsTaxes::model()->deleteAll('order_details_id = ' . $det->order_details_id);
        }
        OrderDetails::model()->deleteAll('order_id = ' . $id);
    }

    public static function mailOrder($order) {

        $supplier = Suppliers::model()->findByPk($order->supplier_nit);

        $mail = new YiiMailer();
        $mail->setView('order');
        $mail->setData(array('model' => $order));
        $mail->setLayout('mailer');
        $mail->setFrom(Yii::app()->params['adminEmail']);
        //$mail->setTo(array('john.cubides87@gmail.com','taromaciro@gmail.com'));
        $mail->setTo(array('john.cubides87@gmail.com', $supplier->supplier_email));
        $mail->setSubject('Orden de Compra # ' . $order->order_consecut);
        //echo Yii::app()->theme->baseUrl.'/adjuntos/prueba.txt';exit;
        $mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
        $mail->send();
    }

    public static function taxSupp($id) {
        $sql = Yii::app()->db->createCommand();
        $sql->select('t.tax_id id, t.tax_rate valor');
        $sql->from('tbl_taxes_supplier tp');
        $sql->join('tbl_taxes t', 'tp.tax_id = t.tax_id');
        $sql->where('tp.supplier_nit = ' . $id);
        $sql->andWhere('t.tax_ishighervalue = 1');
        return $sql->queryAll();
    }

    public static function taxProd($id) {
        $sql = Yii::app()->db->createCommand();
        $sql->select('t.tax_id id, t.tax_rate valor');
        $sql->from('tbl_tax_product tp');
        $sql->join('tbl_taxes t', 'tp.tax_id = t.tax_id');
        $sql->where('tp.product_id = ' . $id);
        $sql->andWhere('t.tax_ishighervalue = 1');
        return $sql->queryAll();
    }

    public static function productsOrder($id) {

        $attributes = array('order_id' => $id);
        $orden = Order::model()->findByAttributes($attributes);
        $products = OrderDetails::model()->findAll('order_id = ' . $orden->order_id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->order_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
        //echo'<pre>';print_r($products[0]->product->product_description);exit;
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('t.order_status <> 3');
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('supplier_nit', $this->supplier_nit);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('order_date', $this->order_date, true);
        $criteria->compare('order_total', $this->order_total);
        $criteria->compare('order_net_worth', $this->order_net_worth);
        $criteria->compare('accounts_id', $this->accounts_id);
        $criteria->compare('order_remarks', $this->order_remarks, true);
        $criteria->compare('order_status', $this->order_status);
        $criteria->compare('company_id', Yii::app()->getSession()->get('empresa'));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
