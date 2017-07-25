<?php

class TransferConfigExtend extends TransferConfig {

    public static function transferCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if (!$empresa)
            $empresa = 0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_in';
        $criteria->condition = 'tbl_wharehouses.company_id = :value';
        $criteria->params = array(":value" => $empresa);
        $model = TransferConfig::model()->findAll($criteria);

        //Count Values
        if (count($model) > 0)
            return $model[0]->id;
    }

    public static function transfersCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_in';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_out';
        $criteria->condition = 'tbl_wharehouses.company_id = :value';
        $criteria->params = array(":value" => $empresa);
        $model =  TransferConfig::model()->findAll($criteria);
        if(count($model)>0)
            return $model[0]->id;
        
        
    }

}
