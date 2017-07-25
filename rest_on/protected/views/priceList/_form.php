<?php
/* @var $this PriceListController */
/* @var $model PriceList */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'price-list-form',
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
		<label><?php echo $form->labelEx($model,'price_type'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-bullseye"></i>
			</div>
			<?php echo $form->dropDownList($model,'price_type',array("1"=>"Compras","2"=>"Ventas"),array('class'=>'form-control','prompt'=>'--Seleccione--')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'price_type', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'price_name'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-bookmark"></i>
			</div><?php echo $form->textField($model,'price_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'price_name', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'price_description'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-sticky-note"></i>
			</div><?php echo $form->textField($model,'price_description',array('size'=>50,'maxlength'=>50,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'price_description', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'price_status'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-shield"></i>
			</div><?php echo $form->dropDownList($model,'price_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'price_status', array('class' => 'alert alert-danger')); ?>
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
		<?php echo CHtml::button('Cancelar', array('class' => 'btn btn-block btn-danger btn-lg', 'data-toggle'=>'modal','data-target'=>'#myModalCancel')); ?> 
		</div>
	</div>
</div>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel'); ?> 

<?php $this->endWidget(); ?>

