<?php

class FinishedProductExtend extends FinishedProduct {
    
    public static function datos(){
        //Producto terminado
        $finish = FinishedProductConfig::model()->findByPk(FinishedProductConfigExtend::finishProductCreate());
        if ($finish) {
            $datos['finishConfig'] = $finish;
            Yii::app()->getSession()->add('impresion', $datos['finishConfig']->finished_product_format);
            Yii::app()->getSession()->add('warehouse', $datos['finishConfig']->wharehouse_id);
        }  

        return $datos;
    }

    public static function viewProducts() {

        $sql = Yii::app()->db->createCommand();
        $sql->select('c.category_id id, c.category_description name');
        $sql->from('tbl_products p');
        $sql->join('tbl_categories c', 'p.category_id = c.category_id');
        $sql->where('p.product_status = 1 ');
        $sql->andWhere('product_iscomponent = 1');
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
            $sql->join('tbl_unit u', 'p.unit_id = u.unit_id');
            $sql->where('p.product_status = 1 ');
            $sql->andWhere('product_iscomponent = 1');
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
        return $datos;
    }
    
    public static function saveFinishedProduct ($id = NULL){
        if (!$id) {
            $datos = FinishedProductConfig::model()->findByPk(FinishedProductConfigExtend::finishProductCreate());
            $model = new FinishedProduct;
            $finishId = $datos->finished_product_id + 1;
        } else {
            $model = FinishedProduct::model()->findByPk($id);
            $finishId = $model->finished_product_consecut;
        }
        $model->attributes = $_POST['FinishedProduct'];
        $model->finished_product_consecut = $finishId;
        $model->user_id = Yii::app()->user->id;
        //$model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if ($model->save()) {
            if (!$id) {
                $datos->finished_product_id = $finishId;
                $datos->save();
            }
            $obs = $model->finished_product_remarks;
            $productos = $_POST['product'];
            if ($id) {
                $detail = FinishedProductDetails::model()->findAll('finished_product_id = ' . $id);
                foreach ($detail as $det) {
                    //SalesDetailsComponent::model()->deleteAll('sales_details_id = ' . $det->sale_details_id);
                    FinishedProductDetails::model()->deleteAll('finished_product_details_id = ' . $det->finished_product_details_id);
                }
            }
            if (!$id)
                $hourInventory = date("H:i:s");
            
            foreach ($productos as $pro) {
                $producto = new FinishedProductDetails;
                $producto->finished_product_id = $model->finished_product_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_inserted = $pro['whare'];
                $producto->finished_product_details_quantity = $pro['cant'];
                $producto->finished_product_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                if ($producto->save()) {
                    //guardando componentes
                    if ($pro['components']) {
                        $datosComponents = json_decode($pro['components']);
                        foreach ($datosComponents as $comp) {
                            $component = new FinishedProductDetailsComponent;
                            $component->finished_product_details_id = $producto->finished_product_details_id;
                            $component->product_id = $comp->product_id;
                            $component->unit_id = $comp->unit_id;
                            $component->quantity = $comp->quantity;
                            $component->save();
                        }
                    } else {
                        
                        $component = new TransfersDetailsComponent;
                            $component->finished_product_details_id = $producto->finished_product_details_id;
                            $component->product_id = $producto->product_id;
                            $component->unit_id = $producto->unit_id;
                            $component->quantity = $producto->finished_product_details_quantity;
                            $component->save();
                    }
                }
            }
        }
        return $model;
    }
    
    public static function finishedProducts($id) { 

        $attributes = array('finished_product_id' => $id);
        $finish = FinishedProduct::model()->findByAttributes($attributes, 'finished_product_status in (1,2)');
        $products = FinishedProductDetails::model()->findAll('finished_product_id = ' . $finish->finished_product_id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->finished_product_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
        //echo'<pre>';print_r($products[0]->product->product_description);exit;
    }

}
