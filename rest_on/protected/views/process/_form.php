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
		<br><?php echo $form->error($model, 'process_cod', array('class' => 'alert alert-danger')); ?>
	</div>
		<div class="form-group">
		<label><?php echo $form->labelEx($model,'process_name'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-bookmark"></i>
			</div><?php echo $form->textField($model,'process_name',array('size'=>60,'maxlength'=>100,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'process_name', array('class' => 'alert alert-danger')); ?>
	</div>
		<div class="form-group">
		<label><?php echo $form->labelEx($model,'unit_id'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-chevron-circle-down"></i>
			</div>
			<?php 
				$base = CHtml::listData(Unit::model()->findAll('unit_status = 1'), 'unit_id', 'unit_name');
				echo $form->dropDownList($model,'unit_id',$base,array('class'=>'form-control','prompt'=>'--Seleccione--')); 
			?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'unit_id', array('class' => 'alert alert-danger')); ?>
	</div>
		<div class="form-group">
		<label><?php echo $form->labelEx($model,'process_unit_value'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-usd"></i>
			</div><?php echo $form->textField($model,'process_unit_value', array('class'=>'form-control')); ?>
			<span class="input-group-addon">.00</span>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'process_unit_value', array('class' => 'alert alert-danger')); ?>
	</div>
		<div class="form-group">
		<label><?php echo $form->labelEx($model,'process_type_cost'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-diamond"></i>
			</div><?php echo $form->dropDownList($model,'process_type_cost',array("1"=>"Fijo","2"=>"Variable"),array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'process_type_cost', array('class' => 'alert alert-danger')); ?>
	</div>
		<div class="form-group">
		<label><?php echo $form->labelEx($model,'process_status'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-shield"></i>
			</div><?php echo $form->dropDownList($model,'process_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'process_status', array('class' => 'alert alert-danger')); ?>
	</div>
</div>
<div class="col-md-12">
	<div class="col-md-6">
		<div class="form-group">
			<?php echo CHtml::button($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success btn-lg', 'onclick' => 'send();')); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">			
			<?php echo CHtml::resetButton('Cancelar', array('class'=>'btn btn-block btn-danger btn-lg')); ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel'); ?>
<?php $this->renderPartial('../_modal'); ?> 

<script>
    function send(form, hasError) {
       url = $("#process-form").attr('action');
       data = $("#process-form").serialize();
        
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
                        document.getElementById("process-form").reset();
                    }
                }, 2500);
                
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>

