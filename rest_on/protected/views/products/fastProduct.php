<!--<script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fileinput/fileinput.css"/>
<?php
/* @var $this ProductsController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'products-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
        'afterValidate' => 'js:mySubmitFormFunction', // Your JS function to submit form
    )
        ));
?>
<div class="col-md-12">

    <div class="row">
        <?php
        //$companies = CHtml::listData(Companies::model()->findAll('company_status=1'), 'company_id', 'company_name');
        echo $form->hiddenfield($model, 'company_id', array('class' => 'form-control', 'value' => Yii::app()->getSession()->get('empresa')));
        ?>


        <div class="col-md-12">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'product_description'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-bookmark"></i>
                    </div>
                    <?php echo $form->textField($model, 'product_description', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>

                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'product_description', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>	

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'product_barCode'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-barcode"></i>
                    </div><?php echo $form->textField($model, 'product_barCode', array('size' => 12, 'maxlength' => 12, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'product_barCode', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'category_id'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-bars"></i>
                    </div>
                    <?php
                    $category = CHtml::listData(Categories::model()->findAll('category_status=1'), 'category_id', 'category_description');
                    echo $form->dropDownList($model, 'category_id', $category, array('class' => 'form-control', 'prompt' => '--Seleccione---'));
                    ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'category_id', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'unit_id'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-chevron-circle-down"></i>
                    </div>
                    <?php
                    $unit = CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name');
                    echo $form->dropDownList($model, 'unit_id', $unit, array('class' => 'form-control', 'prompt' => '--Seleccione--'));
                    ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'unit_id', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'product_price'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-usd"></i>
                    </div><?php echo $form->textField($model, 'product_price', array('class' => 'form-control')); ?>
                    <span class="input-group-addon">.00</span>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'product_price', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'product_status'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-shield"></i>
                    </div><?php echo $form->dropDownList($model, 'product_status', array("1" => "Activo", "0" => "Inactivo"), array('class' => 'form-control')); ?>
                </div><!-- /.input group -->
                <br><?php echo $form->error($model, 'product_status', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'product_remarks'); ?></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-commenting"></i>
                    </div><?php echo $form->textArea($model, 'product_remarks', array('size' => 60, 'maxlength' => 200, 'class' => 'form-control')); ?>
                </div><!-- /.input group -->
            </div>
        </div>        
    </div>
    <?php echo $form->hiddenField($model, 'product_enable', array('class' => 'form-control', 'value' => 1)); ?>
    <?php echo $form->hiddenField($model, 'product_iscomponent', array('class' => 'form-control', 'value' => 0)); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label><?php echo $form->labelEx($model, 'product_image'); ?></label>
                <?php echo $form->fileField($model, 'product_image', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', "accept" => "image/*")); ?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">			
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success btn-lg')); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">			
                <?php echo CHtml::submitButton('Cancelar', array('class' => 'btn btn-block btn-danger btn-lg', 'data-dismiss' => 'modal','id'=>'exit')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>


<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fileinput/fileinput.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fileinput/locales/es.js"></script>
<script>
    function mySubmitFormFunction(form, data, hasError) {
        if (!hasError) {
            // No errors! Do your post and stuff
            // FYI, this will NOT set $_POST['ajax']... 
            $('#exit').click();
            $.post(form.attr('action'), form.serialize(), function(res) {
                // Do stuff with your response data!
                //if (res.result)
                //$('#myModal').modal('hide');
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
    $('input').keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
    $("#Products_product_image").fileinput({
        allowedFileExtensions: ['jpg', 'png'],
        showUpload: false,
        maxImageWidth: 500,
        maxImageHeight: 500,
        language: "es"

    });
</script>



