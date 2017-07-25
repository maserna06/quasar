<?php
/* @var $this TaxesController */
/* @var $model Taxes */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'taxes-form',
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
        ));
?>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'tax_description'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-bookmark"></i>
                    </div><?php echo $form->textField($model, 'tax_description', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'tax_description', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'tax_rate'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-tags"></i>
                    </div><?php echo $form->textField($model, 'tax_rate', array('class' => 'form-control')); ?><span class="input-group-addon">.00</span>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'tax_rate', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo CHtml::label('Aplica Mayor Valor', 'mayor_valor'); ?>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-plus-square"></i>
                    </div>
                    <input name="mayor_valor" <?php echo ($model->tax_ishighervalue == 1)?'checked':''; ?> id ="mayor_valor" class="form-control" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                </div><!-- /.input group -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'tax_status'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-shield"></i>
                    </div><?php echo $form->dropDownList($model, 'tax_status', array("1" => "Activo", "0" => "Inactivo"), array('class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'tax_status', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'tax_cta_income'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-cc-amex"></i>
                    </div>
                    <?php
                    $accountIn = CHtml::listData(Accounts::model()->findAll(), 'account_id', 'account_description');
                    echo $form->dropDownList($model, 'tax_cta_income', $accountIn, array('class' => 'form-control', 'empty' => '--Seleccione--'));
                    ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'tax_cta_income', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'tax_cta_spending'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-cc-amex"></i>
                    </div>
                    <?php
                    $accountOut = CHtml::listData(Accounts::model()->findAll(), 'account_id', 'account_description');
                    echo $form->dropDownList($model, 'tax_cta_spending', $accountOut, array('class' => 'form-control', 'empty' => '--Seleccione--'));
                    ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'tax_cta_spending', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>		
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'economic_activity_cod'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-black-tie"></i>
                    </div>
                    <?php
                    $activity = CHtml::listData(EconomicActivities::model()->findAll('economic_activity_status=1'), 'economic_activity_cod', 'economic_activity_description');
                    echo $form->dropDownList($model, 'economic_activity_cod', $activity, array('class' => 'form-control', 'empty' => '--Seleccione--'));
                    ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'economic_activity_cod', array('class' => 'alert alert-danger')); ?>
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
<?php echo CHtml::button('Cancelar', array('class' => 'btn btn-block btn-danger btn-lg', 'data-toggle' => 'modal', 'data-target' => '#myModalCancel')); ?> 
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
        url = $("#taxes-form").attr('action');
        data = $("#taxes-form").serialize();

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
                        document.getElementById("taxes-form").reset();
                    }
                }, 2500);

            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>