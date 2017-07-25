<?php

use App\User\User as U;

class SalesExtend extends Sales {

    public static function datos() {

        //Ventas
        $sales = SaleConfig::model()->findByPk(RequestConfigExtend::ventasCreate());
        if ($sales) {
            $datos['saleConfig'] = $sales;
            Yii::app()->getSession()->add('impresion', $datos['saleConfig']->sale_format);
            Yii::app()->getSession()->add('warehouse', $datos['saleConfig']->wharehouse_id);
        }

        $userLogged = U::getInstance();
        $wharehouse = WharehousesUser::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        $datos['findWharehouse'] = 0;
        foreach ($wharehouse as $data) {
            if ($data->wharehouses->company_id == $userLogged->companyId) {
                $datos['findWharehouse'] = 1;
                break;
            }
        }

        return $datos;
    }

    public static function saveSale($id = NULL) {
        if (!$id) {
            $datos = SaleConfig::model()->findByPk(RequestConfigExtend::ventasCreate());
            $model = new Sales;
            $saleId = $datos->sale_id + 1;
        } else {
            $model = Sales::model()->findByPk($id);
            $saleId = $model->sale_consecut;
        }
        $dis = $_POST['disCustom'];
        $model->attributes = $_POST['Sales'];
        $model->sale_consecut = $saleId;
        $model->user_id = Yii::app()->user->id;
        $model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if ($model->save()) {
            if (!$id) {
                $datos->sale_id = $saleId;
                $datos->save();
            }
            $obs = $model->sale_remarks;
            $taxCustomer = CustomersExtend::taxCustomer($model->customer_nit);
            $productos = $_POST['product'];
            if ($id) {
                SalesExtend::deleteData($id);
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
                $producto = new SalesDetails;
                $producto->sale_id = $model->sale_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_id = $pro['whare'];
                $producto->sale_details_price = ($precio) ? $precio : $pro['price'];
                $producto->sale_details_discount = ($dis) ? $pro['price'] * $pro['cant'] * $dis : 0;
                $producto->sale_details_quantity = $pro['cant'];
                $producto->sale_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                if ($producto->save()) {
                    // ajustar error tax en customer
                    if ($taxCustomer) {
                        foreach ($taxCustomer as $txsp) {
                            $taxSave = new SalesDetailsTaxes;
                            $taxSave->sale_details_id = $producto->sale_details_id;
                            $taxSave->taxes_id = $txsp['id'];
                            $taxSave->sale_details_tax_value = $producto->sale_details_price * $producto->sale_details_quantity * $txsp['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    SalesExtend::deleteData($model->sale_id);
                                    Sales::model()->deleteAll('sale_id = ' . $model->sale_id);
                                }
                                return 0;
                            }
                        }
                    }
                    if ($taxProd) {
                        foreach ($taxProd as $txpd) {
                            $taxSave = new SalesDetailsTaxes;
                            $taxSave->sale_details_id = $producto->sale_details_id;
                            $taxSave->taxes_id = $txpd['id'];
                            $taxSave->sale_details_tax_value = $producto->sale_details_price * $producto->sale_details_quantity * $txpd['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    SalesExtend::deleteData($model->sale_id);
                                    Sales::model()->deleteAll('sale_id = ' . $model->sale_id);
                                }
                                return 0;
                            }
                        }
                    }
                    //guardando componentes
                    if ($pro['components']) {
                        $datosComponents = json_decode($pro['components']);
                        foreach ($datosComponents as $comp) {
                            $component = new SalesDetailsComponent;
                            $component->sales_details_id = $producto->sale_details_id;
                            $component->product_id = $comp->product_id;
                            $component->unit_id = $comp->unit_id;
                            $component->sales_details_component_quantity = $comp->quantity;
                            if (!$component->save()) {
                                if (!$id) {
                                    SalesExtend::deleteData($model->sale_id);
                                    Sales::model()->deleteAll('sale_id = ' . $model->sale_id);
                                }
                                return 0;
                            }
                            if ($model->sale_status == 1) {
                                //$inventory = InventoriesExtend::addInventoryComponent($comp, $pro['whare'],$model->sale_date, $model->sale_id, 'Sales', $hourInventory);
                            }
                        }
                    } else {
                        $component = new SalesDetailsComponent;
                        $component->sales_details_id = $producto->sale_details_id;
                        $component->product_id = $producto->product_id;
                        $component->unit_id = $producto->unit_id;
                        $component->sales_details_component_quantity = $producto->sale_details_quantity;
                        $component->save();
                    }
                } else {
                    if (!$id) {
                        SalesExtend::deleteData($model->sale_id);
                        Sales::model()->deleteAll('sale_id = ' . $model->sale_id);
                    }
                    return 0;
                }
            }
            if ($model->request_id > 0) {
                $request = Requests::model()->findByPk($model->request_id);
                $request->request_status = 2;
                $request->save();
            }
            if ($_POST['send_mail'] == 'on') {
                SalesExtend::mailRequest($model);
            }
        } else {
            return 0;
        }
        return $model;
    }

    public static function deleteData($id) {
        $detail = SalesDetails::model()->findAll('sale_id = ' . $id);
        foreach ($detail as $det) {
            SalesDetailsTaxes::model()->deleteAll('sale_details_id = ' . $det->sale_details_id);
            //SalesDetailsComponent::model()->deleteAll('sales_details_id = ' . $det->sale_details_id);
            SalesDetails::model()->deleteAll('sale_details_id = ' . $det->sale_details_id);
        }
//                $inventory = Inventories::model()->findAll('inventory_movement_type = "Sales" and inventory_document_number = ' . $id);
//                if ($inventory) {
//                    foreach ($inventory as $inv) {
//                        InventoriesExtend::reverseAddInventory($inv->product_id, $inv->inventory_stock);
//                        $hourInventory = $inv->inventory_hour;
//                    }
//                    Inventories::model()->deleteAll('inventory_movement_type = "Sales" and inventory_document_number = ' . $id);
//                }
    }

    public static function mailRequest($model) {

        $customer = Customers::model()->findByPk($model->customerNit->customer_nit);

        $mail = new YiiMailer();
        $mail->setView('sale');
        $mail->setData(array('model' => $model));
        $mail->setLayout('mailer');
        $mail->setFrom(Yii::app()->params['adminEmail']);
        $mail->setTo(array('john.cubides87@gmail.com', $customer->customer_email));
        $mail->setSubject('Pedido # ' . $model->sale_consecut);
        //echo Yii::app()->theme->baseUrl.'/adjuntos/prueba.txt';exit;
        $mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
        $mail->send();
    }

    public static function productsSale($id) {

        $attributes = array('sale_id' => $id);
        $sale = Sales::model()->findByAttributes($attributes, 'sale_status in (1,2)');
        $products = SalesDetails::model()->findAll('sale_id = ' . $sale->sale_id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->sale_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
        //echo'<pre>';print_r($products[0]->product->product_description);exit;
    }

}
