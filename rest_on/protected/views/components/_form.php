<?php
/* @var $this ComponentsController */
/* @var $model Components */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'components-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<div class="col-md-12">
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'base_product_id'); ?>
</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'base_product_id', array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'product_id'); ?>
</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'product_id', array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'unit_id'); ?>
</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'unit_id', array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'component_amounts'); ?>
</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'component_amounts', array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
	</div>
<div class="col-md-12">
	<div class="col-md-6">
		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-block btn-success btn-lg')); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">			
			<?php echo CHtml::resetButton('Cancelar', array('class'=>'btn btn-block btn-danger btn-lg')); ?>
		</div>
	</div>
</div>


<?php $this->endWidget(); ?>

