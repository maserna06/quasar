<?php
/*
 * Funcion devuelve id de orden config creado
 */
class OrderConfigExtend extends OrderConfig {

    public static function ordenesCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_id';
        $criteria->condition = 'tbl_wharehouses.company_id = :value';
        $criteria->params = array(":value" => $empresa);
        $model =  OrderConfig::model()->findAll($criteria);
        if(count($model)>0)
            return $model[0]->id;
        
        
    }

    public static function remisionesCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_id';
        $criteria->condition = 'tbl_wharehouses.company_id = :value';
        $criteria->params = array(":value" => $empresa);
       $model =  ReferralPConfig::model()->findAll($criteria);

       //Count Values
       if(count($model)>0)
            return $model[0]->id;
    }
    
      public static function comprasCreate() {
        $empresa = User::model()->findByPk(Yii::app()->user->id)->company_id;
        if(!$empresa)
            $empresa=0;
        Yii::app()->getSession()->add('empresa', $empresa);
        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'INNER JOIN tbl_wharehouses ON tbl_wharehouses.wharehouse_id = t.wharehouse_id';
        $criteria->condition = 'tbl_wharehouses.company_id = :value';
        $criteria->params = array(":value" => $empresa);

        //Configuración de Compras
       $model =  PurchaseConfig::model()->findAll($criteria);

       
       if(count($model)>0)
            return $model[0]->id;
    }
    
    public static function increment($table){
        $sql = Yii::app()->db->createCommand();
        $sql->select('AUTO_INCREMENT'); 
        $sql->from('information_schema.TABLES');
        $sql->where('TABLE_SCHEMA = "rests_on" and TABLE_NAME = "'.$table.'"');
        $valor = $sql->queryScalar();
        return ($valor)?$valor:1;
    }
}
