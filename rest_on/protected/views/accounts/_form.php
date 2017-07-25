<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
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
				<label><?php echo $form->labelEx($model,'account_type'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div>
					<?php 
					    $type = CHtml::listData(TypeAccounts::model()->findAll(), 'type_account_id', 'type_account_name');
					    echo $form->dropDownList($model,'account_type',$type,array('class'=>'form-control','prompt'=>'--Seleccione--'));
					?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'account_type', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'account_name'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'account_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control')); ?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'account_name', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
        <div class="col-md-6">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'account_number'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'account_number',array('size'=>20,'maxlength'=>20,'class'=>'form-control')); ?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'account_number', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'account_description'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->textField($model,'account_description',array('size'=>60,'maxlength'=>200,'class'=>'form-control')); ?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'account_description', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
        <div class="col-md-12">
			<div class="form-group">
				<label><?php echo $form->labelEx($model,'account_status'); ?></label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-barcode"></i>
					</div><?php echo $form->dropDownList($model, 'account_status', array("1" => "Activo", "0" => "Inactivo"), array('class' => 'form-control')); ?>
				</div><!-- /.input group -->
				<br><?php echo $form->error($model, 'account_status', array('class' => 'alert alert-danger')); ?>
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
        url = $("#accounts-form").attr('action');
        data = $("#accounts-form").serialize();

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
                setTimeout(function () {
                    $("#myModal").modal('hide');
                    $(".modal-header").removeClass("alert alert-" + datos['estado']);
                    $(".modal-header").addClass("alert alert-success");
                    if (datos['estado'] == 'success') {
                        document.getElementById("accounts-form").reset();
                    }
                }, 2500);

            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>