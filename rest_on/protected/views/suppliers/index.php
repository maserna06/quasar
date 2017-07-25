<?php
/* @var $this SuppliersController */
/* @var $model CompaniesSuppliers */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

$this->menu = array(
  array('label'=>'Crear Proveedor','url'=>array('create'),'visible'=>$visible),
);
?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Proveedores <small>Informaciòn General</small></h3>
        </div>  
        <div class="box-body">

          <div id="Suppliers_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-6"></div>
              <div class="col-sm-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <?php
                $this->widget('zii.widgets.grid.CGridView',array(
                  'id'=>'suppliers-grid',
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
                    array('name'=>'supplier_nit','htmlOptions'=>array('style'=>'width: 60px')),
                    array(
                      'name'=>'supplier_document_type',
                      'filter'=>CHtml::listData(DocumentType::model()->findAll('type_status=1'),'type_id','type_name'),
                      'value'=>'($data->supplierDocumentType!=null) ? $data->supplierDocumentType->type_name : null',
                    ),
                    'supplier_name',
                    'contact_name',
                    'supplier_phone',
                    //'supplier_address',
                    /* array(
                      'name' =>'bank_nit',
                      'filter' => CHtml::listData(Banks::model()->findAll('bank_status=1'), 'bank_nit', 'bank_name'),
                      'value' =>'($data->bankNit!=null) ? $data->bankNit->bank_name : null',
                      ), */
                    array(
                      'name'=>'supplier_is_simplified_regime',
                      'filter'=>array('1'=>'Si','0'=>'No'),
                      'value'=>'($data->supplier_is_simplified_regime=="1")?("Activo"):("Inactivo")'
                    ),
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
                      'name'=>'supplier_status',
                      'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
                      'value'=>'($data->supplier_status=="1")?("Activo"):("Inactivo")'
                    ),
                  /*
                    'supplier_email',
                    'supplier_phonenumber',
                    'price_list_id',
                    'supplier_credit_quota',
                    'supplier_discount',

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
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
