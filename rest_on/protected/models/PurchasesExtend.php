<?php

class PurchasesExtend extends Purchases {

    public static function datos() {
        $fac = PurchaseConfig::model()->findByPk(OrderConfigExtend::comprasCreate());
        if ($fac) {
            $datos['facConfig'] = $fac;
            Yii::app()->getSession()->add('impFac', $datos['facConfig']->purchase_format);
            Yii::app()->getSession()->add('wareFac', $datos['facConfig']->wharehouse_id);
        }

        return $datos;
    }

    public static function savePurchase($id = NULL) {
        if (!$id) {
            $datos = PurchaseConfig::model()->findByPk(OrderConfigExtend::comprasCreate());
            $model = new Purchases;
            $purchaseId = $datos->purchase_id + 1;
        } else {
            $model = Purchases::model()->findByPk($id);
            $purchaseId = $model->purchase_consecut;
        }
        $dis = $_POST['disSup'];
        $model->attributes = $_POST['Purchases'];
        $model->purchase_consecut = $purchaseId;
        $model->user_id = Yii::app()->user->id;
        $model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if ($model->save()) {
            if (!$id) {
                $datos->purchase_id = $purchaseId;
                $datos->save();
            }
            $obs = $model->purchase_remarks;
            $taxSupp = OrderExtend::taxSupp($model->supplier_nit);
            $productos = $_POST['product'];
            if ($id) {
                PurchasesExtend::deleteData($id);
            }
            if (!$id)
                $hourInventory = date("H:i:s");
            foreach ($productos as $pro) {
                $precio = NULL;
                if ($pro['price'] == $pro['precioReal']) {
                    $taxProd = OrderExtend::taxProd($pro['prod']);
                    if ($taxProd)
                        $precio = Products::model()->findByPk($pro['prod'])->product_price;
                }
                $producto = new PurchaseDetails;
                $producto->purchase_id = $model->purchase_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_id = $pro['whare'];
                $producto->purchase_details_price = ($precio) ? $precio : $pro['price'];
                $producto->purchase_details_discount = ($dis) ? $pro['price'] * $pro['cant'] * $dis : 0;
                $producto->purchase_details_quantity = $pro['cant'];
                $producto->purchase_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                if ($producto->save()) {
                    if ($taxSupp) {
                        foreach ($taxSupp as $txsp) {
                            $taxSave = new PurchaseDetailsTaxes;
                            $taxSave->purchase_details_id = $producto->purchase_details_id;
                            $taxSave->tax_id = $txsp['id'];
                            $taxSave->purchase_details_tax_value = $producto->purchase_details_price * $producto->purchase_details_quantity * $txsp['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    PurchasesExtend::deleteData($model->purchase_id);
                                    Purchases::model()->deleteAll('purchase_id = ' . $model->purchase_id);
                                }
                                return 0;
                            }
                        }
                    }
                    if ($taxProd) {
                        foreach ($taxProd as $txpd) {
                            $taxSave = new PurchaseDetailsTaxes;
                            $taxSave->purchase_details_id = $producto->purchase_details_id;
                            $taxSave->tax_id = $txpd['id'];
                            $taxSave->purchase_details_tax_value = $producto->purchase_details_price * $producto->purchase_details_quantity * $txpd['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    PurchasesExtend::deleteData($model->purchase_id);
                                    Purchases::model()->deleteAll('purchase_id = ' . $model->purchase_id);
                                }
                                return 0;
                            }
                        }
                    }
                    if ($model->purchase_status == 1) {
                        //$inventory = InventoriesExtend::addInventory($pro, $model->purchase_date, $model->purchase_id, 'Purchases', $hourInventory);
                    }
                } else {
                    if (!$id) {
                        PurchasesExtend::deleteData($model->purchase_id);
                        Purchases::model()->deleteAll('purchase_id = ' . $model->purchase_id);
                    }
                     return 0;
                }
            }
            if ($model->order_id > 0) {
                $order = Order::model()->findByPk($model->order_id);
                $order->order_status = 2;
                $order->save();
            }
            if ($_POST['send_mail'] == 'on') {
                PurchasesExtend::mailPurchase($model);
            }
        } else {
            return 0;
        }
        return $model;
    }

    public static function deleteData($id) {
        $detail = PurchaseDetails::model()->findAll('purchase_id = ' . $id);
        foreach ($detail as $det) {
            PurchaseDetailsTaxes::model()->deleteAll('purchase_details_id = ' . $det->purchase_details_id);
            PurchaseDetailsTaxes::model()->deleteAll('purchase_details_id = ' . $det->purchase_details_id);
            PurchaseDetails::model()->deleteAll('purchase_details_id= ' . $det->purchase_details_id);
        }
    }

    public static function mailPurchase($model) {

        $supplier = Suppliers::model()->findByPk($model->supplier_nit);

        $mail = new YiiMailer();
        $mail->setView('purchase');
        $mail->setData(array('model' => $model));
        $mail->setLayout('mailer');
        $mail->setFrom(Yii::app()->params['adminEmail']);
        //$mail->setTo(array('john.cubides87@gmail.com','taromaciro@gmail.com'));
        $mail->setTo(array('john.cubides87@gmail.com', $supplier->supplier_email));
        $mail->setSubject('Factura de Compra # ' . $model->purchase_consecut);
        //echo Yii::app()->theme->baseUrl.'/adjuntos/prueba.txt';exit;
        $mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
        $mail->send();
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('t.purchase_status <> 3');
        $criteria->compare('purchase_id', $this->purchase_id);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('supplier_nit', $this->supplier_nit);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('purchase_date', $this->purchase_date, true);
        $criteria->compare('purchase_total', $this->purchase_total);
        $criteria->compare('purchase_net_worth', $this->purchase_net_worth);
        $criteria->compare('accounts_id', $this->accounts_id);
        $criteria->compare('purchase_remarks', $this->purchase_remarks, true);
        $criteria->compare('purchase_status', $this->purchase_status);
        $criteria->compare('company_id', Yii::app()->getSession()->get('empresa'));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function productsPurchases($id) {

        $attributes = array('purchase_id' => $id);
        $purchase = Purchases::model()->findByAttributes($attributes);
        $products = PurchaseDetails::model()->findAll('purchase_id = ' . $purchase->purchase_id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->purchase_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
    }

}
