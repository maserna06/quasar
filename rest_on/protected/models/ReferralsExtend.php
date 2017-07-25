<?php

use App\User\User as U;

class ReferralsExtend extends Referrals {

    public static function datos($table) {
        $increment = $valor = RequestConfigExtend::increment($table);
        $datos['increment'] = RequestsExtend::largoInc($increment);

        //Remisiones
        $referrals = ReferralConfig::model()->findByPk(RequestConfigExtend::remisionesCreate());
        if ($referrals) {
            $datos['referralConfig'] = $referrals;
            Yii::app()->getSession()->add('impresion', $datos['referralConfig']->referral_format);
            Yii::app()->getSession()->add('warehouse', $datos['referralConfig']->wharehouse_id);
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

    public static function saveReferral($id = NULL) {
        if (!$id) {
            $datos = ReferralConfig::model()->findByPk(RequestConfigExtend::remisionesCreate());
            $model = new Referrals;
            $referralId = $datos->referral_id + 1;
        } else {
            $model = Referrals::model()->findByPk($id);
            $referralId = $model->referral_consecut;
        }
        $dis = $_POST['disSup'];
        $model->attributes = $_POST['Referrals'];
        $model->referral_consecut = $referralId;
        $model->user_id = Yii::app()->user->id;
        $model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if ($model->save()) {
            if (!$id) {
                $datos->referral_id = $referralId;
                $datos->save();
            }
            $obs = $model->referral_remarks;
            $taxCustomer = CustomersExtend::taxCustomer($model->customer_nit);
            $productos = $_POST['product'];
            if ($id) {
                ReferralsExtend::deleteData($id);
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
                $producto = new ReferralsDetails;
                $producto->referral_id = $model->referral_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_id = $pro['whare'];
                $producto->referral_details_price = ($precio) ? $precio : $pro['price'];
                $producto->referral_details_discount = ($dis) ? $pro['price'] * $pro['cant'] * $dis : 0;
                $producto->referral_details_quantity = $pro['cant'];
                $producto->referral_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                if ($producto->save()) {
                    // ajustar error tax en customer
                    if ($taxCustomer) {
                        foreach ($taxCustomer as $txsp) {
                            $taxSave = new ReferralsDetailsTaxes;
                            $taxSave->referral_details_id = $producto->referral_details_id;
                            $taxSave->taxes_id = $txsp['id'];
                            $taxSave->referral_details_tax_value = $producto->referral_details_price * $producto->referral_details_quantity * $txsp['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    ReferralsExtend::deleteData($model->referral_id);
                                    Referrals::model()->deleteAll('referral_id = ' . $model->referral_id);
                                }
                                return 0;
                            }
                        }
                    }
                    if ($taxProd) {
                        foreach ($taxProd as $txpd) {
                            $taxSave = new ReferralsDetailsTaxes;
                            $taxSave->referral_details_id = $producto->referral_details_id;
                            $taxSave->taxes_id = $txpd['id'];
                            $taxSave->referral_details_tax_value = $producto->referral_details_price * $producto->referral_details_quantity * $txpd['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    ReferralsExtend::deleteData($model->referral_id);
                                    Referrals::model()->deleteAll('referral_id = ' . $model->referral_id);
                                }
                                return 0;
                            }
                        }
                    }

                    //guardando componentes
                    if ($pro['components']) {
                        $datosComponents = json_decode($pro['components']);
                        foreach ($datosComponents as $comp) {
                            $component = new ReferralsDetailsComponent;
                            $component->referrals_details_id = $producto->referral_details_id;
                            $component->product_id = $comp->product_id;
                            $component->unit_id = $comp->unit_id;
                            $component->referrals_details_component_quantity = $comp->quantity;
                            if (!$component->save()) {
                                if (!$id) {
                                    ReferralsExtend::deleteData($model->referral_id);
                                    Referrals::model()->deleteAll('referral_id = ' . $model->referral_id);
                                }
                                return 0;
                            }
                            if ($model->referral_status == 1) {
                                //$inventory = InventoriesExtend::addInventoryComponent($comp, $pro['whare'],$model->referral_date, $model->referral_id, 'Referrals', $hourInventory);
                            }
                        }
                    } else {
                        $component = new ReferralsDetailsComponent;
                        $component->referrals_details_id = $producto->referral_details_id;
                        $component->product_id = $producto->product_id;
                        $component->unit_id = $producto->unit_id;
                        $component->referrals_details_component_quantity = $producto->referral_details_quantit;
                        $component->save();
                    }
                } else {
                    if (!$id) {
                        ReferralsExtend::deleteData($model->referral_id);
                        Referrals::model()->deleteAll('referral_id = ' . $model->referral_id);
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
                ReferralsExtend::mailRequest($model);
            }
        } else {
            return 0;
        }
        return $model;
    }

    public static function deleteData($id) {
        $detail = ReferralsDetails::model()->findAll('referral_id = ' . $id);
        foreach ($detail as $det) {
            ReferralsDetailsTaxes::model()->deleteAll('referral_details_id = ' . $det->referral_details_id);
            //ReferralsDetailsComponent::model()->deleteAll('referrals_details_id = ' . $det->referral_details_id);
            ReferralsDetails::model()->deleteAll('referral_details_id = ' . $det->referral_details_id);
        }

//                $inventory = Inventories::model()->findAll('inventory_movement_type = "Referrals" and inventory_document_number = ' . $id);
//                if ($inventory) {
//                    foreach ($inventory as $inv) {
//                        InventoriesExtend::reverseAddInventory($inv->product_id, $inv->inventory_stock);
//                        $hourInventory = $inv->inventory_hour;
//                    }
//                    Inventories::model()->deleteAll('inventory_movement_type = "Referrals" and inventory_document_number = ' . $id);
//                }
    }

    public static function mailRequest($model) {

        $customer = Customers::model()->findByPk($model->customerNit->customer_nit);

        $mail = new YiiMailer();
        $mail->setView('referral');
        $mail->setData(array('model' => $model));
        $mail->setLayout('mailer');
        $mail->setFrom(Yii::app()->params['adminEmail']);
        //$mail->setTo(array('john.cubides87@gmail.com','taromaciro@gmail.com'));
        $mail->setTo(array('john.cubides87@gmail.com', $customer->customer_email));
        $mail->setSubject('Pedido # ' . $model->referral_consecut);
        //echo Yii::app()->theme->baseUrl.'/adjuntos/prueba.txt';exit;
        $mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
        $mail->send();
    }

    public static function productsReferral($id) {

        $attributes = array('referral_id' => $id);
        $referral = Referrals::model()->findByAttributes($attributes, 'referral_status in (1,2)');
        $products = ReferralsDetails::model()->findAll('referral_id = ' . $referral->referral_id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->referral_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
        //echo'<pre>';print_r($products[0]->product->product_description);exit;
    }

}
