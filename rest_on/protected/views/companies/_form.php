<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'companies-form',
    'htmlOptions' => array("class" => "form",
        'onsubmit' => "return false;", /* Disable normal form submit */
        'enctype' => 'multipart/form-data'
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
                <label><?php echo $form->labelEx($model, 'company_id'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-barcode"></i>
                    </div><?php echo $form->textField($model, 'company_id', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'company_id', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'company_name'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-industry"></i>
                    </div><?php echo $form->textField($model, 'company_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'company_name', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'company_phone'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                    </div><?php echo $form->textField($model, 'company_phone', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'company_phone', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'company_address'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-map-signs"></i>
                    </div><?php echo $form->textField($model, 'company_address', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'company_logo'); ?></label>
                <?php echo $form->fileField($model, 'company_logo', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', "accept" => "image/*")); ?>
                <br><?php echo $form->error($model, 'company_logo', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'company_url'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-cloud"></i>
                    </div><?php echo $form->textField($model, 'company_url', array('size' => 500, 'maxlength' => 500, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'company_url', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>	
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'deparment_id'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-map"></i>
                    </div>
                    <?php
                    $departaments = CHtml::listData(Departaments::model()->findAll('deparment_state=1'), 'deparment_id', 'deparment_name');
                    echo $form->dropDownList($model, 'deparment_id', $departaments, array('class' => 'form-control', 'prompt' => '--Seleccione--',
                        'ajax' => array(
                            'url' => CController::createUrl('citiesByDepartament'), //action en el controlador
                            'type' => 'POST',
                            'update' => '#' . CHtml::activeId($model, 'city_id'),
                        ),
                    ));
                    ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'deparment_id', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'city_id'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <?php
                    $cities = CHtml::listData(Cities::model()->findAll('city_state=1'), 'city_id', 'city_name');
                    echo $form->dropDownList($model, 'city_id', $cities, array('class' => 'form-control', 'prompt' => '--Seleccione--'));
                    ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'city_id', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'company_status'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-shield"></i>
                    </div>
                    <?php echo $form->dropDownList($model, 'company_status', array("1" => "Activo", "0" => "Inactivo"), array('class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'company_status', array('class' => 'alert alert-danger')); ?>
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
<script>
    $("#Companies_company_logo").fileinput({
        allowedFileExtensions: ['jpg', 'png'],
        showUpload: false,
        maxImageWidth: 350,
        maxImageHeight: 350,
        language: "es"
    });

</script>
<?php $this->endWidget(); ?>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel'); ?>
<?php $this->renderPartial('../_modal'); ?> 

<script>
    function send(form, hasError) {
        url = $("#companies-form").attr('action');
        data = $("#companies-form").serialize();
        var formData = new FormData(document.getElementById("companies-form"));

        if (!hasError) {

            $.ajax({
                url: url,
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function (res) {
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
                        document.getElementById("companies-form").reset();
                    }
                }, 2500);
            });

        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>