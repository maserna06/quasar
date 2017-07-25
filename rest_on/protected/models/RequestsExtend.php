<?php

error_reporting(E_ALL);

use App\User\User as U;

error_reporting(E_ALL);

class RequestsExtend extends Requests {

    public static function datos() {
        //Pedidos
        $requests = RequestConfig::model()->findByPk(RequestConfigExtend::pedidosCreate());
        if ($requests) {
            $datos['RequestConfig'] = $requests;
            Yii::app()->getSession()->add('impresion', $datos['RequestConfig']->request_format);
            Yii::app()->getSession()->add('warehouse', $datos['RequestConfig']->wharehouse_id);
        }
        $userLogged = U::getInstance();
        $wharehouse = WharehousesUser::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        $datos['findWharehouse'] = 0;
        foreach ($wharehouse as $data) {
            if ($data->wharehouses->company_id = $userLogged->companyId) {
                $datos['findWharehouse'] = 1;
                break;
            }
        }
        return $datos;
    }

    public static function largoInc($value) {
        $large = strlen($value);
        if (5 - $large > 0)
            $value = str_repeat("0", 5 - $large) . $value;

        return $value;
    }

    public static function viewProducts() {

        $sql = Yii::app()->db->createCommand();
        $sql->select('c.classification_id id, c.classification_name name');
        $sql->from('tbl_products p');
        $sql->join('tbl_classification_product i', 'p.product_id = i.product_id');
        $sql->join('tbl_classification c', 'i.classification_id = c.classification_id');
        $sql->where('p.product_status = 1 ');
        $sql->andWhere('p.company_id = ' . Yii::app()->getSession()->get('empresa'));
        $sql->group('c.classification_id');

        $clasificaciones = $sql->queryAll();

        $datos = array();
        $i = 0;
        foreach ($clasificaciones as $clasf) {
            $datos[$i]['datos'] = $clasf;
            $sql = Yii::app()->db->createCommand();
            $sql->select('p.*');
            $sql->from('tbl_products p');
            $sql->join('tbl_classification_product i', 'p.product_id = i.product_id');
            $sql->join('tbl_classification c', 'i.classification_id = c.classification_id');
            $sql->where('p.product_status = 1 ');
            $sql->andWhere('i.classification_id = ' . $clasf['id']);
            $sql->andWhere('p.company_id = ' . Yii::app()->getSession()->get('empresa'));
            $sql->order('p.product_description');
            $productos = $sql->queryAll();
            for ($o = 0; $o < count($productos); $o++) {
                $tax = ProductsExtend::addProdTax($productos[$o]['product_id']);
                if ($tax > 0) {
                    $tax = 1 + ($tax / 100);
                    $productos[$o]['product_price'] = $productos[$o]['product_price'] * $tax;
                }
            }
            $datos[$i]['prod'] = $productos;
            $i++;
        }
        return $datos;
    }

    public static function saveRequest($id = NULL) {
        if (!$id) {
            $datos = RequestConfig::model()->findByPk(RequestConfigExtend::pedidosCreate());
            $model = new Requests;
            $requestId = $datos->request_id + 1;
        } else {
            $model = Requests::model()->findByPk($id);
            $requestId = $model->request_id;
        }
        $dis = $_POST['disSup'];
        $model->attributes = $_POST['Requests'];
        $model->request_consecut = $requestId;
        $model->user_id = Yii::app()->user->id;
        $model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if ($model->save()) {
            if (!$id) {
                $datos->request_id = $requestId;
                $datos->save();
            }
            $obs = $model->request_remarks;
            $taxCustomer = CustomersExtend::taxCustomer($model->customer_nit);
            $productos = $_POST['product'];
            if ($id) {
                RequestsExtend::deleteData($id);
            }
            foreach ($productos as $pro) {
                $precio = NULL;
                if ($pro['price'] == $pro['precioReal']) {
                    $taxProd = OrderExtend::taxProd($pro['prod']);
                    if ($taxProd)
                        $precio = Products::model()->findByPk($pro['prod'])->product_price;
                }
                $producto = new RequestsDetails;
                $producto->request_id = $model->request_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_id = $pro['whare'];
                $producto->request_details_price = ($precio) ? $precio : $pro['price'];
                $producto->request_details_discount = ($dis) ? $pro['price'] * $pro['cant'] * $dis : 0;
                $producto->request_details_quantity = $pro['cant'];
                $producto->request_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                if ($producto->save()) {
                    if ($taxCustomer) {
                        foreach ($taxCustomer as $txsp) {
                            $taxSave = new RequestsDetailsTaxes;
                            $taxSave->request_details_id = $producto->request_details_id;
                            $taxSave->taxes_id = $txsp['id'];
                            $taxSave->request_details_tax_value = $pro['price'] * $producto->request_details_quantity * $txsp['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    RequestsExtend::deleteData($model->request_id);
                                    Requests::model()->deleteAll('request_id = ' . $model->request_id);
                                }
                                return 0;
                            }
                        }
                    }
                    if ($taxProd) {
                        foreach ($taxProd as $txpd) {
                            $taxSave = new RequestsDetailsTaxes;
                            $taxSave->request_details_id = $producto->request_details_id;
                            $taxSave->taxes_id = $txpd['id'];
                            $taxSave->request_details_tax_value = $producto->request_details_price * $producto->request_details_quantity * $txpd['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    RequestsExtend::deleteData($model->request_id);
                                    Requests::model()->deleteAll('request_id = ' . $model->request_id);
                                }
                                return 0;
                            }
                        }
                    }
                    //guardando componentes
                    if ($pro['components']) {
                        $datosComponents = json_decode($pro['components']);
                        foreach ($datosComponents as $comp) {
                            $component = new RequestsDetailsComponent;
                            $component->requests_details_id = $producto->request_details_id;
                            $component->product_id = $comp->product_id;
                            $component->unit_id = $comp->unit_id;
                            $component->requests_details_component_quantity = $comp->quantity;
                            if (!$component->save()) {
                                if (!$id) {
                                    RequestsExtend::deleteData($model->request_id);
                                    Requests::model()->deleteAll('request_id = ' . $model->request_id);
                                }
                                return 0;
                            }
                        }
                    }
                } else {
                    if (!$id) {
                        RequestsExtend::deleteData($model->request_id);
                        Requests::model()->deleteAll('request_id = ' . $model->request_id);
                    }
                    return 0;
                }
            }
            if ($_POST['send_mail'] == 'on') {
                RequestsExtend::mailRequest($model);
            }
        } else {
            return 0;
        }
        return $model;
    }

    public static function deleteData($id) {
        $detail = RequestsDetails::model()->findAll('request_id = ' . $id);
        foreach ($detail as $det) {
            RequestsDetailsTaxes::model()->deleteAll('request_details_id = ' . $det->request_details_id);
            RequestsDetailsComponent::model()->deleteAll('requests_details_id = ' . $det->request_details_id);
        }
        RequestsDetails::model()->deleteAll('request_id = ' . $id);
    }

    public static function mailRequest($model) {

        $customer = Customers::model()->findByPk($model->customerNit->customer_nit);

        $mail = new YiiMailer();
        $mail->setView('request');
        $mail->setData(array('model' => $model));
        $mail->setLayout('mailer');
        $mail->setFrom(Yii::app()->params['adminEmail']);
        //$mail->setTo(array('john.cubides87@gmail.com','taromaciro@gmail.com'));
        $mail->setTo(array('john.cubides87@gmail.com', $customer->customer_email));
        $mail->setSubject('Pedido # ' . $model->request_consecut);
        //echo Yii::app()->theme->baseUrl.'/adjuntos/prueba.txt';exit;
        $mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
        $mail->send();
    }

    public static function productsRequest($id) {

        $attributes = array('request_id' => $id);
        $request = Requests::model()->findByAttributes($attributes, 'request_status in (1,2)');
        $products = RequestsDetails::model()->findAll('request_id = ' . $request->request_id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->request_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
        //echo'<pre>';print_r($products[0]->product->product_description);exit;
    }

}
