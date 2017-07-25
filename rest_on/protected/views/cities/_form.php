<?php
/* @var $this CitiesController */
/* @var $model Cities */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cities-form',
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
		<label><?php echo $form->labelEx($model,'city_cod'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-barcode"></i>
			</div><?php echo $form->textField($model,'city_cod',array('size'=>10,'maxlength'=>10,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'city_cod', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'city_name'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-map-marker"></i>
			</div><?php echo $form->textField($model,'city_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'city_name', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'deparment_cod'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-map"></i>
			</div>
			<?php 
				$departaments = CHtml::listData(Departaments::model()->findAll('deparment_state=1'), 'deparment_cod', 'deparment_name');
				echo $form->dropDownList($model,'deparment_cod',$departaments,array('class'=>'form-control','empty'=>'--Seleccione--')); 
			?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'deparment_cod', array('class' => 'alert alert-danger')); ?>
	</div>
	<div class="form-group">
		<label><?php echo $form->labelEx($model,'city_state'); ?></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-shield"></i>
			</div>
			<?php echo $form->dropDownList($model,'city_state',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control')); ?>
		</div><!-- /.input group -->
		<br><?php echo $form->error($model, 'city_state', array('class' => 'alert alert-danger')); ?>
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
       url = $("#cities-form").attr('action');
       data = $("#cities-form").serialize();
        
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
                        document.getElementById("cities-form").reset();
                    }
                }, 2500);
                
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>

