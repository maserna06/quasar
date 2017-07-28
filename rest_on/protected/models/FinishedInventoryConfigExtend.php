<?php

class FinishedInventoryConfigExtend extends InventoryConfig {

    public static function finishInventoryCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_companies ON tbl_companies.company_id = t.company_id';
        $criteria->condition = 'tbl_companies.company_id = :value';
        $criteria->params = array(":value" => $empresa);
        $model = InventoryConfig::model()->findAll($criteria);

        //Count Values
        if(count($model)>0)
            return $model[0]->id;
        
        
    }

    public static function finishedinventoryCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_companies ON tbl_companies.company_id = t.company_id';
        $criteria->condition = 'tbl_companies.company_id = :value';
        $criteria->params = array(":value" => $empresa);
       $model =  InventoryConfig::model()->findAll($criteria);

       //Count Values
       if(count($model)>0)
            return $model[0]->id;
    }
}
