<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Ver Cuentas Contables', 'url'=>array('index')),
	array('label'=>'Crear Cuenta Contable', 'url'=>array('create'), 'visible'=>$visible),
);

?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Cuentas Contables <small>Formulario de Administracion</small></h3>
        </div>  
        <div class="box-body">            
          	<div id="Accounts_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          		<div class="row">
          			<div class="col-sm-6"></div>
          			<div class="col-sm-6"></div>
          		</div>
          		<div class="row">
					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'accounts-grid',
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
							//array('name' => 'account_id', 'htmlOptions' => array('style' => 'width: 80px')),
							array(
						        'name' =>'account_type',
						        'filter' => CHtml::listData(TypeAccounts::model()->findAll(), 'type_account_id', 'type_account_name'),
						        'value' =>'($data->accountType!=null) ? $data->accountType->type_account_name : null',
						    ),
							'account_name',
							'account_number',
							'account_description',
							array(
								'name'=>'account_status',
								'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
								'value'=>'($data->account_status=="1")?("Activo"):("Inactivo")'
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
