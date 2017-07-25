<?php

use App\User\User as U;
use App\Utils\Purifier;

/**
 * Modelo extendido de Products por si hay actualizaciones en base de datos 
 * y se genera el modelo por GII no se vean afectadas las funciones personalizadas
 */
class ProductsExtend extends Products{

  public static function newProduct($product = NULL){
    $purifier = Purifier::getInstance();
    $user = U::getInstance();
    $attributes = $purifier->purify($_POST['Products']);
    if($user->isSupervisor && !$user->isSuper){
      $attributes['company_id'] = $user->companyId;
    }
    if($product)
      $model = Products::model()->findByPk($product); // si $product es diferente de null declara el modelo del producto aeditar
    else 
      $model = new Products; // Producto para crear
      
    // se valida si el archivo ya existe y no se va a reempazar
    $archivo = (!$model->product_image)?'product-250x250.jpg':$model->product_image;
    $model->attributes = $attributes;
    $model->product_image = $archivo;
    $model->save();

    if($model->product_id && $_FILES){ // si viene archivo y existe el producto se reliza al carga del archivo al servidor
      $uploads_dir = 'themes/dashboard/dist/img/';
      $tmp_name = $_FILES["Products"]["tmp_name"]['product_image'];
      $archivo = $_FILES["Products"]["name"]['product_image'];
      $extension = CFileHelper::getExtension($archivo); //end(explode(".",$_FILES["Products"]["name"]['product_image']));
      $name = Yii::app()->controller->id.'-'.$model->product_id.'.'.$extension;
      if(move_uploaded_file($tmp_name,$uploads_dir.$name))
          $model->product_image = $name;
      $model->save();


      if($model->product_iscomponent == 0){
        Components::model()->deleteAllByAttributes(array('base_product_id'=>$model->product_id));
      }else{
        $components = $purifier->purify($_POST['component']);
        if(count($components)){
          Components::model()->deleteAllByAttributes(array('base_product_id'=>$model->product_id));
          foreach($components['prod'] as $index=> $productId){
            $componente = new Components();
            $componente->base_product_id = $model->product_id;
            $componente->product_id = $productId;
            $componente->unit_id = $components['und'][$index];
            $componente->component_amounts = $components['cant'][$index];
            $componente->save();
          }
        }
      }
    }
    return $model;
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   *
   * Typical usecase:
   * - Initialize the model fields with values from filter form.
   * - Execute this method to get CActiveDataProvider instance which will filter
   * models according to data in model fields.
   * - Pass data provider to CGridView, CListView or any similar widget.
   *
   * @return CActiveDataProvider the data provider that can return the models
   * based on the search/filter conditions.
   */
  public function search(){
    // @todo Please modify the following code to remove attributes that should not be searched.

    $criteria = new CDbCriteria;

    $criteria->with = array('company'=>array('joinType'=>'INNER JOIN','together'=>true,));

    $criteria->addCondition('t.product_status in (0,1)');

    $criteria->compare('product_id',$this->product_id);
    $criteria->compare('product_description',$this->product_description,true);
    $criteria->compare('product_barCode',$this->product_barCode,true);
    $criteria->compare('category_id',$this->category_id);
    $criteria->compare('product_iva',$this->product_iva);
    $criteria->compare('product_price',$this->product_price);
    $criteria->compare('unit_id',$this->unit_id);
    $criteria->compare('product_min_stock',$this->product_min_stock);
    $criteria->compare('product_max_stock',$this->product_max_stock);
    $criteria->compare('product_inventory_max_days',$this->product_inventory_max_days);
    $criteria->compare('product_image',$this->product_image,true);
    $criteria->compare('product_iscomponent',$this->product_iscomponent);
    $criteria->compare('product_enable',$this->product_enable);
    $criteria->compare('product_remarks',$this->product_remarks,true);
    $criteria->compare('product_status',$this->product_status);

    $user = U::getInstance();

    if($user->isSupervisor && !$user->isSuper){
      $criteria->compare('t.company_id',$user->companyId);
      $criteria->order = 'product_description ASC';
    }else{
      $criteria->compare('t.company_id',$this->company_id,true);
      $criteria->order = 'product_description ASC';
      $criteria->order = 'company.company_name ASC';
    }




    return new CActiveDataProvider($this,array(
      'criteria'=>$criteria,
    ));
  }

  public static function unidadesComp(){
    CHtml::dropDownList('component[und'.$cant.']','i',CHtml::listData(Unit::model()->findAll('unit_status=1'),'unit_id','unit_name'));
  }

  public static function taxesProd($id){
    $taxes = Taxes::model()->findAll('tax_status=1');
    $datos = array();
    $i = 0;
    foreach($taxes as $tax){
      $taxProd = TaxProduct::model()->findByAttributes(array('tax_id'=>$tax->tax_id,'product_id'=>$id));
      $datos[$i]['id'] = $tax->tax_id;
      $datos[$i]['name'] = $tax->tax_description;
      $datos[$i]['estado'] = ($taxProd)?'On':'Off';
      $i++;
    }
    return $datos;
  }

  public static function taxesSave(){
    $att = array('product_id'=>$_GET['product'],'tax_id'=>$_GET['tax']);
    if($_GET['accion'] == 1){
      $tax = new TaxProduct;
      $tax->attributes = $att;
      $tax->save();
      return 'Impuesto asignado correctamente.';
    }else{
      $tax = TaxProduct::model()->deleteAllByAttributes($att);
      return 'Impuesto desasignado correctamente.';
    }
  }

  public static function addProdTax($id){

    $sql = Yii::app()->db->createCommand();
    $sql->select('sum(t.tax_rate)');
    $sql->from('tbl_tax_product tp');
    $sql->join('tbl_taxes t','tp.tax_id = t.tax_id');
    $sql->where('tp.product_id = '.$id);
    $sql->andWhere('t.tax_ishighervalue = 1');
    return $sql->queryScalar();
  }

}
