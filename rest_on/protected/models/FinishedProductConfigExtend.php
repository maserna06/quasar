<?php

class FinishedProductConfigExtend extends FinishedProductConfig {

    public static function finishProductCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_id';
        $criteria->condition = 'tbl_wharehouses.company_id = :value';
        $criteria->params = array(":value" => $empresa);
        $model = FinishedProductConfig::model()->findAll($criteria);

        //Count Values
        if(count($model)>0)
            return $model[0]->id;
        
        
    }

    public static function finishedproductCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_id';
        $criteria->condition = 'tbl_wharehouses.company_id = :value';
        $criteria->params = array(":value" => $empresa);
       $model =  FinishedProductConfig::model()->findAll($criteria);

       //Count Values
       if(count($model)>0)
            return $model[0]->id;
    }
}
