<?php
/* @var $this ConversionUnitController */
/* @var $model ConversionUnit */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Ver Conversion de Unidad', 'url'=>array('index')),
	array('label'=>'Crear Conversion de Unidad', 'url'=>array('create'), 'visible'=>$visible),
);

?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Conversion de Unidad <small>Formulario de Administracion</small></h3>
        </div>  
        <div class="box-body">            
          	<div id="ConversionUnit_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          		<div class="row">
          			<div class="col-sm-6"></div>
          			<div class="col-sm-6"></div>
          		</div>
          		<div class="row">
					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'conversion-unit-grid',
						'itemsCssClass' => 'table table-bordered table-hover dataTable',
						'htmlOptions'=>array('class' => 'col-sm-12' ),
						'summaryText'=>'',
                        'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
                            'firstPageLabel' => '<<',
                            'lastPageLabel' => '>>',
                            'prevPageLabel' => '<',
                            'nextPageLabel' => '>',),
                        'pagerCssClass' => 'col-sm-12', 
						'dataProvider'=>$model->search(),
						'filter' => $model,
						'columns'=>array(
							//array('name' => 'convertion_id', 'htmlOptions' => array('style' => 'width: 60px')),
							array(
						        'name' =>'convertion_base_unit',
						        'filter' => CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name'),
						        'value' =>'($data->convertionBaseUnit!=null) ? $data->convertionBaseUnit->unit_name : null',
						    ),
							array(
						        'name' =>'convertion_destination_unit',
						        'filter' => CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name'),
						        'value' =>'($data->convertionDestinationUnit!=null) ? $data->convertionDestinationUnit->unit_name : null',
						    ),
							'convertion_factor',
							array(
								'name'=>'convertion_status',
								'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
								'value'=>'($data->convertion_status=="1")?("Activo"):("Inactivo")'
							),
							array(
								'class'=>'CButtonColumn',
								'template'=>'{update}{delete}',
								'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
								'buttons'=>array
							    (
							        /*'view' => array
							        (
							            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
						                'label' => '<i class="fa fa-eye" style="margin: 5px;"></i>',
						                'imageUrl' => false,
							        ),*/
							        'update' => array
							        (
							            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Actualizar"),
						                'label' => '<i class="fa fa-pencil" style="margin: 5px;"></i>',
						                'imageUrl' => false,
							        ),
							        'delete' => array
							        (
							            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Eliminar"),
						                'label' => '<i class="fa fa-times" style="margin: 5px;"></i>',
						                'imageUrl' => false,
							        ),
							    ),
							),
						),
					)); ?>
				</div>
        	</div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
