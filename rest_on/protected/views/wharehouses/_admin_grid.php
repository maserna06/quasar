<?php

use App\User\User as U;

/* @var $this WharehousesController */
/* @var $model Wharehouses */
/* @var $admin boolean */
/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */
$user=U::getInstance();
$isAdmin=$user->isAdmin;
$columns=[];
if($user->isSuper){
  $columns[]=array(
    'name'=>'company_id',
    'filter'=>CHtml::listData(Companies::model()->findAll('company_status=1'),'company_id','company_name'),
    'value'=>'($data->company!=null) ? $data->company->company_name : null',
  );
}

$columns=array_merge($columns,array(
  //array('name' => 'wharehouse_id', 'htmlOptions' => array('style' => 'width: 60px')),
  'wharehouse_name',
  'wharehouse_phone',
  'wharehouse_address',
  array(
    'name'=>'city_id',
    'filter'=>CHtml::listData(Cities::model()->findAll('city_state=1'),'city_id','city_name'),
    'value'=>'($data->city!=null) ? $data->city->city_name : null',
  ),
  array(
    'name'=>'deparment_id',
    'filter'=>CHtml::listData(Departaments::model()->findAll('deparment_state=1'),'deparment_id','deparment_name'),
    'value'=>'($data->deparment!=null) ? $data->deparment->deparment_name : null',
  ),
  array(
    'name'=>'wharehouse_status',
    'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
    'value'=>'($data->wharehouse_status=="1")?("Activo"):("Inactivo")'
  )));
$columns[]=[
  'class'=>'CButtonColumn',
  //'header'=>'Acciones',
  'template'=>$isAdmin?'{view}{update}{delete}':'{view}{update}',
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
  'id'=>'wharehouses-grid',
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
