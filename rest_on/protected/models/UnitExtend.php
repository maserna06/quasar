<?php

class UnitExtend extends Unit {

    public static function selectConversion($id) {
        $sql = Yii::app()->db->createCommand();
        $sql->select('u.unit_id id, u.unit_name name');
        $sql->from('tbl_unit u');
        $sql->join('tbl_conversion_unit c', 'u.unit_id = c.convertion_destination_unit');
        $sql->where('u.unit_status = 1 ');
        $sql->andWhere('c.convertion_base_unit ='.$id);
        $sql->group('c.convertion_destination_unit');
        $unidades = $sql->queryAll();
        $actual = Unit::model()->findByPk($id);
        $dato['id']= $actual->unit_id;
        $dato['name'] = $actual->unit_name;
        $unidades[]=$dato;
        return CHtml::listData($unidades,'id','name');
    }
    
     public static function Conversion($destination, $real, $valor){
        $factor = ConversionUnit::model()->findByAttributes(array('convertion_base_unit'=>$real,'convertion_destination_unit'=>$destination));
        return $valor/$factor->convertion_factor;
    }

}
