<?php
/* @var $this UnidadController */
/* @var $model Unit */

use App\User\User as U;
$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Unidad', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Actualizar Unidad', 'url'=>array('update', 'id'=>$model->unit_id)),
	array('label'=>($isAdmin?'Administrar':'Ver').' Unidades','url'=>array('index')),
);
?>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'unit_id',
		'unit_iternational_unit',
		'unit_name',
		'unit_status',
	),
));*/ ?>

<section class="invoice"><!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-file-text"></i> Detalle de Unidad
        <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
      </h2>
    </div><!-- /.col -->
  </div><!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      Unidad
      <address>
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
            <button id="export_pdf" type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> Generar PDF
            </button>
        </div>
    </div>
</section>

<?php
    Yii::app()->clientScript->registerScript("export", "
        $('#export_pdf').click(function(){
            if(confirm('" . Yii::t('application', 'Generation time can take up to 5 minutes, depending on the number of records. Want to continue?') . "')){
                window.open('" . Yii::app()->controller->createUrl('exportPdf', array('type' => 'PDF', 'id' => $model->unit_id)) . "', '', 'hotkeys=no, height=500, width=700');
            }
            return false;
        });
    ", CClientScript::POS_READY);
?>