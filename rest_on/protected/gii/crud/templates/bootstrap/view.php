<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Ver <?php echo $this->modelClass; ?>', 'url'=>array('index')),
	array('label'=>'Crear <?php echo $this->modelClass; ?>', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Actualizar <?php echo $this->modelClass; ?>', 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	#array('label'=>'Delete <?php echo $this->modelClass; ?>', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar <?php echo $this->modelClass; ?>', 'url'=>array('admin'), 'visible'=>$visible),
);
?>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
	foreach($this->tableSchema->columns as $column)
		echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>

<section class="invoice"><!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-file-text"></i> Detalle de <?php echo $this->getModelClass(); ?>
        <small class="pull-right">Fecha: <?php echo "<?php echo date('j/n/Y'); ?>" ?></small>
      </h2>
    </div><!-- /.col -->
  </div><!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      <?php echo $this->getModelClass(); ?>
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
      <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
        <i class="fa fa-download"></i> Generar PDF
      </button>
    </div>
  </div>
</section>
