<?php
/* @var $this InventoriesController */
/* @var $model Inventories */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Ver Inventories', 'url'=>array('index')),
	array('label'=>'Crear Inventories', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Actualizar Inventories', 'url'=>array('update', 'id'=>$model->inventory_id)),
	#array('label'=>'Delete Inventories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->inventory_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Inventories', 'url'=>array('admin'), 'visible'=>$visible),
);
?>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'inventory_id',
		'wharehouse_id',
		'product_id',
		'inventory_year',
		'inventory_month',
		'inventory_unit',
		'inventory_stock',
		'inventory_movement_type',
		'inventory_document_number',
		'inventory_amounts',
		'inventory_status',
	),
));*/ ?>

<section class="invoice"><!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-file-text"></i> Detalle de Inventories        
        <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
      </h2>
    </div><!-- /.col -->
  </div><!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      Inventories      <address>
        <strong> </strong><br>
        <br>
        <br>
        Cedula: <br>
        Email: 
      </address>
    </div><!-- /.col -->
    <div class="col-sm-4 invoice-col">
      De
      <address>
        <strong></strong><br>
        <br>
        Empresa: <br>
        Direccion: <br>
        Telefono: 
      </address>
    </div><!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b>Otros Datos</b><br>
      <br>
      <b>Activacion:</b> <br>
      <b>Celular:</b> <br>
      <b>Estado:</b> 
    </div><!-- /.col -->
  </div><!-- /.row -->
  <br>
  <!-- Table row -->
  <div class="row">
	<div class="col-sm-12 invoice-col">
		<h2 class="page-header">
			<i class="fa fa-group"></i> Detallado
			<small class="pull-right"> </small>
		</h2>
	</div><!-- /.col -->
    <div class="col-xs-12">
	    <ul class="nav nav-tabs nav-stacked">
	    	
	    </ul>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <br>
  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">
      <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>
      <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
        <i class="fa fa-download"></i> Generar PDF
      </button>
    </div>
  </div>
</section>
