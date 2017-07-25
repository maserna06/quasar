<?php

class TransfersExtend extends Transfers {

    public static function datos() {

        //Transferencias
        $sales = TransferConfig::model()->findByPk(TransferConfigExtend::transferCreate());
        if ($sales) {
            $datos['transferConfig'] = $sales;
            Yii::app()->getSession()->add('impresion', $datos['saleConfig']->transfer_format);
            Yii::app()->getSession()->add('warehouse', $datos['saleConfig']->wharehouse_in);
        }

        return $datos;
    }

    public static function saveTransfer($id = NULL) {
        if (!$id) {
            $datos = TransferConfig::model()->findByPk(TransferConfigExtend::transferCreate());
            $model = new Transfers;
            $transferId = $datos->transfer_id + 1;
        } else {
            $model = Transfers::model()->findByPk($id);
            $transferId = $model->transfer_consecut;
        }
        $model->attributes = $_POST['Transfers'];
        $model->transfer_consecut = $transferId;
        $model->user_id = Yii::app()->user->id;
        //$model->company_id = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if ($model->save()) {
            if (!$id) {
                $datos->transfer_id = $transferId;
                $datos->save();
            }
            $obs = $model->transfer_remarks;
            $productos = $_POST['product'];
            if ($id) {
                $detail = TransfersDetails::model()->findAll('transfer_id = ' . $id);
                foreach ($detail as $det) {
                    //SalesDetailsComponent::model()->deleteAll('sales_details_id = ' . $det->sale_details_id);
                    TransfersDetails::model()->deleteAll('transfer_details_id = ' . $det->transfer_details_id);
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
            if (!$id)
                $hourInventory = date("H:i:s");

            foreach ($productos as $pro) {
                $producto = new TransfersDetails;
                $producto->transfer_id = $model->transfer_id;
                $producto->product_id = $pro['prod'];
                $producto->wharehouse_out = $pro['whare'];
                $producto->wharehouse_in = $pro['whare-in'];
                $producto->transfer_details_quantity = $pro['cant'];
                $producto->transfer_details_remarks = $obs;
                $producto->unit_id = $pro['und'];
                if ($producto->save()) {
                    //guardando componentes
                    /*
                     * Se quitan guardar componentes ya que no se requiere en este movimiento
                     
                    if ($pro['components']) {
                        $datosComponents = json_decode($pro['components']);
                        foreach ($datosComponents as $comp) {
                            $component = new TransfersDetailsComponent;
                            $component->transfer_details_id = $producto->transfer_details_id;
                            $component->product_id = $comp->product_id;
                            $component->unit_id = $comp->unit_id;
                            $component->quantity = $comp->quantity;
                            $component->save();
                        }
                    } else {
                        $component = new TransfersDetailsComponent;
                        $component->transfer_details_id = $producto->transfer_details_id;
                        $component->product_id = $producto->product_id;
                        $component->unit_id = $producto->unit_id;
                        $component->quantity = $producto->transfer_details_quantity;
                        $component->save();
                    }
                     * 
                     */
                }
            }
        }
        return $model;
    }
    
    public static function viewProducts() {

        $sql = Yii::app()->db->createCommand();
        $sql->select('c.category_id id, c.category_description name');
        $sql->from('tbl_products p');
        $sql->join('tbl_categories c', 'p.category_id = c.category_id');
        $sql->where('p.product_status = 1 ');
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
    
    public static function transferProducts($id) { 

        $products = TransfersDetails::model()->findAll('transfer_id = ' . $id);
        $datos = array();
        foreach ($products as $prod) {
            $datos[] = $prod->transfer_details_id;
        }
        $datos = json_encode($datos);
        return $datos;
        //echo'<pre>';print_r($products[0]->product->product_description);exit;
    }

}
