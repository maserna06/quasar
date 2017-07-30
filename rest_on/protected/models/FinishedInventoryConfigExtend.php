<?php

class FinishedInventoryConfigExtend extends InventoryConfig {

    public static function finishedinventoryCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $model =  InventoryConfig::model()->find("company_id = ?", array($empresa));
        
        //Count Values
        if(count($model)>0)
            return $model->config_id;
    }
}
