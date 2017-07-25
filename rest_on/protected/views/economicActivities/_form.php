<?php
/* @var $this EconomicActivitiesController */
/* @var $model EconomicActivities */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'economic-activities-form',
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
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'economic_activity_cod'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'economic_activity_cod',array('size'=>11,'maxlength'=>11,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'economic_activity_cod', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'economic_activity_description'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-bookmark"></i>
			</div><?php echo $form->textField($model,'economic_activity_description',array('size'=>50,'maxlength'=>50,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'economic_activity_description', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'economic_activity_status'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-shield"></i>
			</div><?php echo $form->dropDownList($model,'economic_activity_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'economic_activity_status', array('class' => 'alert alert-danger')); ?>
	</div>
</div>
<div class="col-md-12">
	<div class="col-md-6">
		<div class="form-group">
			<?php echo CHtml::button($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-block btn-success btn-lg', 'onclick' => 'send();')); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">			
			<?php echo CHtml::button('Cancelar', array('class'=>'btn btn-block btn-danger btn-lg', 'data-toggle'=>'modal','data-target'=>'#myModalCancel')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel'); ?>
<?php $this->renderPartial('../_modal'); ?> 

<script>
    function send(form, hasError) {
       url = $("#economic-activities-form").attr('action');
       data = $("#economic-activities-form").serialize();
        
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
                        document.getElementById("economic-activities-form").reset();
                    }
                }, 2500);
                
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>