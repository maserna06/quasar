<?php
/* @var $this ConversionUnitController */
/* @var $model ConversionUnit */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'conversion-unit-form',
	'htmlOptions' => array("class" => "form",
		'onsubmit' => "return false;", /* Disable normal form submit */
	),
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
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'convertion_base_unit'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-chevron-circle-down"></i>
					</div>
					<?php 
						$base = CHtml::listData(Unit::model()->findAll('unit_status = 1'), 'unit_id', 'unit_name');
						echo $form->dropDownList($model,'convertion_base_unit',$base,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
					?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'convertion_base_unit', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
        <div class="col-md-6">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'convertion_destination_unit'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-chevron-circle-up"></i>
					</div>
					<?php 
						$destination = CHtml::listData(Unit::model()->findAll('unit_status = 1'), 'unit_id', 'unit_name');
						echo $form->dropDownList($model,'convertion_destination_unit',$destination,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
					?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'convertion_destination_unit', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'convertion_factor'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-superscript"></i>
					</div><?php echo $form->textField($model,'convertion_factor', array('class'=>'form-control')); ?>
					<span class="input-group-addon">.0</span>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'convertion_factor', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
        <div class="col-md-6">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'convertion_status'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-shield"></i>
					</div><?php echo $form->dropDownList($model,'convertion_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control')); ?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'convertion_status', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo CHtml::button($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success btn-lg', 'onclick' => 'send();')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">			
            <?php echo CHtml::button('Cancelar', array('class' => 'btn btn-block btn-danger btn-lg', 'data-toggle'=>'modal','data-target'=>'#myModalCancel')); ?> 
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel'); ?>
<?php $this->renderPartial('../_modal'); ?> 

<script>
    function send(form, hasError) {
       url = $("#conversion-unit-form").attr('action');
       data = $("#conversion-unit-form").serialize();
        
        if (!hasError) {
            // No errors! Do your post and stuff
            // FYI, this will NOT set $_POST['ajax']... 
            //$('#exit').click();
            $.post(url, data, function (res) {
                var datos = $.parseJSON(res);
                $("#bodyArchivos").html("<div class='col-md-12'>" + datos['mensaje'] + "</div>");
                $("#myModal").modal({keyboard: false});
                $(".modal-dialog").width("40%");
                $(".modal-title").html("Información");
                $(".modal-header").removeClass("alert alert-success");
                $(".modal-header").addClass("alert alert-" + datos['estado']);
                $(".modal-header").show();
                $(".modal-footer").html("");
                setTimeout(function () {
                    $("#myModal").modal('hide');
                    $(".modal-header").removeClass("alert alert-" + datos['estado']);
                    $(".modal-header").addClass("alert alert-success");
                    if (datos['estado'] == 'success') {
                        document.getElementById("conversion-unit-form").reset();
                    }
                }, 2500);
                
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>

