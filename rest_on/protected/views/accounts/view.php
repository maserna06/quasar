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
	array('label'=>'Actualizar Cuenta Contable', 'url'=>array('update', 'id'=>$model->account_id)),
	#array('label'=>'Delete Cuentas Contables', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Cuentas Contables', 'url'=>array('admin'), 'visible'=>$visible),
);
?>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'account_id',
		'account_type',
		'account_name',
		'account_number',
		'account_description',
		'account_status',
	),
));*/ ?>

<section class="invoice"><!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-file-text"></i> Detalle de Cuenta Contable        
        <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
      </h2>
    </div><!-- /.col -->
  </div><!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      Cuenta Contable      
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
                window.open('" . Yii::app()->controller->createUrl('exportPdf', array('type' => 'PDF', 'id' => $model->account_id)) . "', '', 'hotkeys=no, height=500, width=700');
            }
            return false;
        });
    ", CClientScript::POS_READY);
?>