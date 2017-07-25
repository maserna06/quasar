<?php

/**
 * Modelo extendido de Customers por si hay actualizaciones en base de datos 
 * y se genera el modelo por GII no se vean afectadas las funciones personalizadas
 */
class CustomersExtend extends Customers {


    public static function taxesCustom($id) {
        $taxes = Taxes::model()->findAll('tax_status=1');
        $datos = array();
        $i = 0;
        foreach ($taxes as $tax) {
            $taxProd = TaxesCustomer::model()->findByAttributes(array('tax_id' => $tax->tax_id, 'customer_nit' => $id));
            $datos[$i]['id'] = $tax->tax_id;
            $datos[$i]['name'] = $tax->tax_description;
            $datos[$i]['estado'] = ($taxProd) ? 'On' : 'Off';
            $i++;
        }
        return $datos;
    }
    
    public static function taxesSave() {
        $att = array('customer_nit' => $_GET['customer'], 'tax_id' => $_GET['tax']);
        if ($_GET['accion'] == 1) {
            $tax = new TaxesCustomer;
            $tax->attributes = $att;
            $tax->save();
            return 'Impuesto asignado correctamente.';
        } else {
            $tax = TaxesCustomer::model()->deleteAllByAttributes($att);
            return 'Impuesto desasignado correctamente.';
        }
    }
    /*
     * Devuelve array con datos de impuestos por cliente.
     */
    public static function taxCustomer($id) {
        $sql = Yii::app()->db->createCommand();
        $sql->select('t.tax_id id, t.tax_rate valor');
        $sql->from('tbl_taxes_customer tp');
        $sql->join('tbl_taxes t', 'tp.tax_id = t.tax_id');
        $sql->where('tp.customer_nit = ' . $id);
        $sql->andWhere('t.tax_ishighervalue = 1');
        return $sql->queryAll();
    }
    
     public static function customerCompany (){
        
        $empresa = (Yii::app()->getSession()->get('empresa'))?Yii::app()->getSession()->get('empresa'):'company_nit';
        $customer = CompaniesCustomers::model()->findAll('company_nit = '.$empresa);
        $datos = array();
        $i=0;
        foreach ($customer as $cus){
            if($cus->customer->customer_status == 1){
                $datos[$i]['id'] = $cus->customer_nit;
                $datos[$i]['name'] = $cus->customer->customer_firtsname.' '.$cus->customer->customer_lastname;
            }
            $i++;
        }
        
        return CHtml::listData($datos,'id','name');
    }
    
    

}
