<?php

use App\User\User as U;

/* @var $this CustomersController */
/* @var $model CompaniesCustomers */
$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;
$this->menu=array(
//  array('label'=>($isAdmin?'Administrar':'Ver').' Clientes','url'=>array('index')),
  array('label'=>'Crear Cliente','url'=>array('create'),'visible'=>$visible),
);
?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Clientes <small>Formulario de Administracion</small></h3>
        </div>  
        <div class="box-body">            
          <div id="Customers_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-6"></div>
              <div class="col-sm-6"></div>
            </div>
            <div class="row">
              <?php
              $this->widget('zii.widgets.grid.CGridView',array(
                'id'=>'customers-grid',
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
                'columns'=>array(
                  array(
                    'name'=>'customer_document_type',
                    'filter'=>CHtml::listData(DocumentType::model()->findAll('type_status=1'),'type_id','type_name'),
                    'value'=>'($data->customerDocumentType!=null) ? $data->customerDocumentType->type_name : null',
                  ),
                  array(
                    'name'=>'customer_nit',
                    'htmlOptions'=>array('style'=>'width: 60px')
                  ),
                  'customer_firtsname',
                  'customer_lastname',
                  'customer_email',
                  'customer_phone',
                  //'customer_address',
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
                    'name'=>'customer_status',
                    'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
                    'value'=>'($data->customer_status=="1")?("Activo"):("Inactivo")'
                  ),
                  /* 							
                    'customer_phonenumber',
                    'bank_nit',
                    'price_list_id',
                    'customer_credit_quota',
                    'customer_discount',
                   */
                  array(
                    'class'=>'CButtonColumn',
                    'template'=>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                    'htmlOptions'=>array('style'=>'width: 10%; text-align: center;'),
                    'buttons'=>array
                      (
                      'view'=>array
                        (
                        'options'=>array('rel'=>'tooltip','data-toggle'=>'tooltip','title'=>"Ver"),
                        'label'=>'<i class="fa fa-eye" style="margin: 5px;"></i>',
                        'imageUrl'=>false,
                      ),
                      'update'=>array
                        (
                        'options'=>array('rel'=>'tooltip','data-toggle'=>'tooltip','title'=>"Actualizar"),
                        'label'=>'<i class="fa fa-pencil" style="margin: 5px;"></i>',
                        'imageUrl'=>false,
                      ),
                      'delete'=>array
                        (
                        'options'=>array('rel'=>'tooltip','data-toggle'=>'tooltip','title'=>"Eliminar"),
                        'label'=>'<i class="fa fa-times" style="margin: 5px;"></i>',
                        'imageUrl'=>false,
                      ),
                    ),
                  ),
                ),
              ));
              ?>
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
