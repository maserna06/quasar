<?php
/* @var $this ProcessController */
/* @var $model Process */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'process-form',
	'htmlOptions' => array("class" => "form",
        'onsubmit' => "return false;", /* Disable normal form submit */
    ),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
)); ?>
<div class="col-md-12">
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'process_cod'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'process_cod',array('size'=>5,'maxlength'=>5,'class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'process_name'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'process_name',array('size'=>60,'maxlength'=>100,'class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'unit_id'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'unit_id', array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'process_unit_value'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'process_unit_value', array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'process_type_cost'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'process_type_cost', array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
			</div>
				<div class="form-group">
				<label><?php echo $form->labelEx($model,'process_status'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'process_status', array('class'=>'form-control')); ?>
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

