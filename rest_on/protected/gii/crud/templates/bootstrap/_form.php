<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>
<div class="col-md-12">
	<?php
	foreach($this->tableSchema->columns as $column)
	{
		if($column->autoIncrement)
			continue;
	?>
			<div class="form-group">
				<label><?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column,array('class'=>'form-control'))."; ?>\n"; ?>
				</div><!-- /.input group -->
			</div>
	<?php
	}
	?>
</div>
<div class="col-md-12">
	<div class="col-md-6">
		<div class="form-group">
			<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-block btn-success btn-lg')); ?>\n"; ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">			
			<?php echo "<?php echo CHtml::resetButton('Cancelar', array('class'=>'btn btn-block btn-danger btn-lg')); ?>\n"; ?>
		</div>
	</div>
</div>


<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

