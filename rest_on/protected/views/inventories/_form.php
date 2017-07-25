<?php
/* @var $this InventoriesController */
/* @var $model Inventories */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventories-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'validateOnType' => true,
	),
)); ?>
<div class="col-md-12">
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'wharehouse_id'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'wharehouse_id', array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'product_id'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'product_id', array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_year'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_year',array('size'=>4,'maxlength'=>4,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_month'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_month',array('size'=>2,'maxlength'=>2,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_unit'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_unit', array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_stock'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_stock', array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_movement_type'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_movement_type',array('size'=>10,'maxlength'=>10,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_document_number'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_document_number', array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_amounts'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_amounts', array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'inventory_status'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'inventory_status', array('class'=>'form-control')); ?>
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

