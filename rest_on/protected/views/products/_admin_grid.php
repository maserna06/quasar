<?php

use App\User\User as U;

/* @var $this WharehousesController */
/* @var $model Wharehouses */
/* @var $admin boolean */
/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */
$user=U::getInstance();
$columns=[];
if($user->isSuper){
  $columns[]=array(
    'name'=>'company_id',
    'filter'=>CHtml::listData(Companies::model()->findAll('company_status=1'),'company_id','company_name'),
    'value'=>'($data->company!=null) ? $data->company->company_name : null',
  );
}
$columns=array_merge($columns,array(
//array('name' => 'product_id', 'htmlOptions' => array('style' => 'width: 60px')),

  'product_description',
  array(
    'name'=>'category_id',
    'filter'=>CHtml::listData(Categories::model()->findAll('category_status=1'),'category_id','category_description'),
    'value'=>'($data->category!=null) ? $data->category->category_description : null',
  ),
  //'product_iva',
  'product_price',
  array(
    'name'=>'unit_id',
    'filter'=>CHtml::listData(Unit::model()->findAll('unit_status=1'),'unit_id','unit_name'),
    'value'=>'($data->unit!=null) ? $data->unit->unit_name : null',
  ),
  array(
    'name'=>'product_iscomponent',
    'filter'=>array('1'=>'Si','0'=>'No'),
    'value'=>'($data->product_iscomponent=="1")?("Si"):("No")'
  ),
  array(
    'name'=>'product_enable',
    'filter'=>array('1'=>'Si','0'=>'No'),
    'value'=>'($data->product_enable=="1")?("Si"):("No")'
  ),
  array(
    'name'=>'product_status',
    'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
    'value'=>'($data->product_status=="1")?("Activo"):("Inactivo")'
  ),
  )
);
$columns[]=[
  'class'=>'CButtonColumn',
  'header'=>'Acciones',
  'template'=>$admin?'{view}{update}{delete}':'{view}{update}',
  'htmlOptions'=>array('style'=>'width: 10%; text-align: center;'),
  'buttons'=>[
    'view'=>[
      'options'=>array('rel'=>'tooltip','data-toggle'=>'tooltip','title'=>"Ver"),
      'label'=>'<i class="fa fa-eye" style="margin: 5px;"></i>',
      'imageUrl'=>false,
    ],
    'update'=>[
      'options'=>array('rel'=>'tooltip','data-toggle'=>'tooltip','title'=>"Actualizar"),
      'label'=>'<i class="fa fa-pencil" style="margin: 5px;"></i>',
      'imageUrl'=>false,
    ],
    'delete'=>[
      'options'=>array('rel'=>'tooltip','data-toggle'=>'tooltip','title'=>"Eliminar"),
      'label'=>'<i class="fa fa-times" style="margin: 5px;"></i>',
      'imageUrl'=>false,
    ],
  ],
];

$this->widget('zii.widgets.grid.CGridView',array(
  'id'=>'products-grid',
  'itemsCssClass'=>'table table-bordered table-hover dataTable',
  'htmlOptions'=>array('class'=>'col-sm-12'),
  'summaryText'=>'',
  'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
    'firstPageLabel'=>'<<',
    'lastPageLabel'=>'>>',
    'prevPageLabel'=>'<',
    'nextPageLabel'=>'>',),
  'pagerCssClass'=>'col-sm-12',
  'dataProvider'=>$model->search(),
  'filter'=>$model,
  'columns'=>$columns,
));
