<?php

/**
 * Modelo extendido de Suppliers por si hay actualizaciones en base de datos 
 * y se genera el modelo por GII no se vean afectadas las funciones personalizadas
 */
class SuppliersExtend extends Suppliers {


    public static function taxesSupplier($id) {

        $taxes = Taxes::model()->findAll('tax_status=1');
        $datos = array();
        $i = 0;
        foreach ($taxes as $tax) {
            $taxProd = TaxesSupplier::model()->findByAttributes(array('tax_id' => $tax->tax_id, 'supplier_nit' => $id));
            $datos[$i]['id'] = $tax->tax_id;
            $datos[$i]['name'] = $tax->tax_description;
            $datos[$i]['estado'] = ($taxProd) ? 'On' : 'Off';
            $i++;
        }

        return $datos;
    }
    
    public static function taxesSave() {
        $att = array('supplier_nit' => $_GET['supplier'], 'tax_id' => $_GET['tax']);
        if ($_GET['accion'] == 1) {
            $tax = new TaxesSupplier;
            $tax->attributes = $att;
            $tax->save();
            return 'Impuesto asignado correctamente.';
        } else {
            $tax = TaxesSupplier::model()->deleteAllByAttributes($att);
            return 'Impuesto desasignado correctamente.';
        }
    }
    
    public static function supplierCompany (){

        $supp = CompaniesSuppliers::model()->findAll('company_nit = '.Yii::app()->getSession()->get('empresa'));
        $datos = array();
        $i=0;
        foreach ($supp as $sup){
            if($sup->supplier->supplier_status == 1){
                $datos[$i]['id'] = $sup->supplier_nit;
                $datos[$i]['name'] = $sup->supplier->supplier_name;
            }
            $i++;
        }
        return CHtml::listData($datos,'id','name');
    }
}
