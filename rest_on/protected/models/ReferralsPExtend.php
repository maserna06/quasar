<?php

use App\User\User as U;

class ReferralsPExtend extends ReferralsP {

    public static function datos($table) {
        $increment = $valor = OrderConfigExtend::increment($table);
        $datos['increment'] = RequestsExtend::largoInc($increment);

        //Remisiones
        $referrals = ReferralPConfig::model()->findByPk(OrderConfigExtend::remisionesCreate());
        if ($referrals) {
            $datos['referralPConfig'] = $referrals;
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
            $datos = ReferralPConfig::model()->findByPk(OrderConfigExtend::remisionesCreate());
            $model = new ReferralsP;
            $referralId = $datos->referralP_id + 1;
        } else {
            $model = ReferralsP::model()->findByPk($id);
            $referralId = $model->referralP_consecut;
        }
        $dis = $_POST['disCustom'];
        $model->attributes = $_POST['ReferralsP'];
        $model->referralP_consecut = $referralId;
        $model->user_id = Yii::app()->user->id;
        $model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;

        if ($model->save()) {
            if (!$id) {
                $datos->referralP_id = $referralId;
                $datos->save();
            }

            $obs = $model->referralP_remarks;            
            $taxCustomer = SuppliersExtend::taxesSupplier($model->customer_nit);
            $productos = $_POST['product'];

            if ($id) {
                ReferralsPExtend::deleteData($id);
            }

            foreach ($productos as $pro) {
                $precio = NULL;
                if ($pro['price'] == $pro['precioReal']) {
                    $taxProd = OrderExtend::taxProd($pro['prod']);
                    if ($taxProd)
                        $precio = Products::model()->findByPk($pro['prod'])->product_price;
                }
                $producto = new ReferralsPDetails;
                $producto->referralP_id = $model->referralP_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_id = $pro['whare'];
                $producto->referralP_details_price = ($precio) ? $precio : $pro['price'];
                $producto->referralP_details_discount = ($dis) ? $pro['price'] * $pro['cant'] * $dis : 0;
                $producto->referralP_details_quantity = $pro['cant'];
                $producto->referralP_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                 
                if ($producto->save()) {
                    // ajustar error tax en customer
                    if ($taxCustomer) {
                        foreach ($taxCustomer as $txsp) {
                            $taxSave = new ReferralsPDetailsTaxes;
                            $taxSave->referralP_details_id = $producto->referralP_details_id;
                            $taxSave->taxes_id = $txsp['id'];
                            $taxSave->referralP_details_tax_value = $producto->referralP_details_price * $producto->referralP_details_quantity * $txsp['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    ReferralsPExtend::deleteData($model->referralP_id);
                                    ReferralsP::model()->deleteAll('referralP_id = ' . $model->referralP_id);
                                }
                                return 0;
                            }
                        }
                    }
                    if ($taxProd) {
                        foreach ($taxProd as $txpd) {
                            $taxSave = new ReferralsPDetailsTaxes;
                            $taxSave->referralP_details_id = $producto->referralP_details_id;
                            $taxSave->taxes_id = $txpd['id'];
                            $taxSave->referralP_details_tax_value = $producto->referralP_details_price * $producto->referralP_details_quantity * $txpd['valor'] / 100;
                            if (!$taxSave->save()) {
                                if (!$id) {
                                    ReferralsPExtend::deleteData($model->referralP_id);
                                    ReferralsP::model()->deleteAll('referralP_id = ' . $model->referralP_id);
                                }
                                return 0;
                            }
                        }
                    }
                    
                } else {
                    if (!$id) {
                        ReferralsPExtend::deleteData($model->referralP_id);
                        ReferralsP::model()->deleteAll('referralP_id = ' . $model->referralP_id);
                    }
                    return 0;
                }
            }
            if ($model->request_id > 0) {
                $request = Order::model()->findByPk($model->request_id);
                $request->order_status = 2;
                $request->save();
            }
            if ($_POST['send_mail'] == 'on') {
                ReferralsPExtend::mailRequest($model);
            }
        } else {
            return 0;
        }
        return $model;
    }

    public static function deleteData($id) {
        $detail = ReferralsPDetails::model()->findAll('referralP_id = ' . $id);
        foreach ($detail as $det) {
            ReferralsPDetailsTaxes::model()->deleteAll('referralP_details_id = ' . $det->referralP_details_id);            
            ReferralsPDetails::model()->deleteAll('referralP_details_id = ' . $det->referralP_details_id);
        }
    }

    public static function mailRequest($model) {

        $customer = Customers::model()->findByPk($model->customerNit->customer_nit);

        $mail = new YiiMailer();
        $mail->setView('referralP');
        $mail->setData(array('model' => $model));
        $mail->setLayout('mailer');
        $mail->setFrom(Yii::app()->params['adminEmail']);
        
        $mail->setTo(array('john.cubides87@gmail.com', $customer->customer_email));
        $mail->setSubject('Pedido # ' . $model->referralP_consecut);
        
        $mail->setAttachment(array('themes/dashboard/adjuntos/prueba.txt'));
        $mail->send();
    }

    public static function productsReferral($id) {

        $attributes = array('referralP_id' => $id);
        $referral = ReferralsP::model()->findByAttributes($attributes, 'referralP_status in (1,2)');
        $products = ReferralsPDetails::model()->findAll('referralP_id = ' . $referral->referralP_id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->referralP_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
        
    }

}
