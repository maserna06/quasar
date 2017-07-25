<?php

use App\User\User as U;

/* @var $this WharehousesController */
/* @var $model Wharehouses */
/* @var $form CActiveForm */
$user=U::getInstance();
?>

<?php
$form=$this->beginWidget('CActiveForm',array(
  'id'=>'wharehouses-form',
  'htmlOptions' => array("class" => "form",
      'onsubmit' => "return false;", /* Disable normal form submit */
  ),
  // Please note: When you enable ajax validation, make sure the corresponding
  // controller action is handling ajax validation correctly.
  // There is a call to performAjaxValidation() commented in generated controller code.
  // See class documentation of CActiveForm for details on this.
  'enableAjaxValidation'=>false,
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
    'validateOnChange'=>true,
    'validateOnType'=>true,
  ),
  ));
?>
<div class="col-md-12">
  <div class="row">
    <?php if($user->isSuper): ?>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'company_id');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-industry"></i>
          </div>
          <?php
          $companies=CHtml::listData(Companies::model()->findAll('company_status=1'),'company_id','company_name');
          echo $form->dropDownList($model,'company_id',$companies,array('class'=>'form-control','empty'=>'--Seleccione--'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'company_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <?php endif; ?>
    <div class="col-md-<?php echo $user->isSuper?6:12?>">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'wharehouse_name');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-bookmark"></i>
          </div><?php echo $form->textField($model,'wharehouse_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'wharehouse_name',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'wharehouse_phone');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-phone"></i>
          </div><?php echo $form->textField($model,'wharehouse_phone',array('size'=>20,'maxlength'=>20,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'wharehouse_phone',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'wharehouse_address');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-map-signs"></i>
          </div><?php echo $form->textField($model,'wharehouse_address',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'wharehouse_address',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'deparment_id');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-map"></i>
          </div>
          <?php
          $departaments=CHtml::listData(Departaments::model()->findAll('deparment_state=1'),'deparment_id','deparment_name');
          echo $form->dropDownList($model,'deparment_id',$departaments,array('class'=>'form-control','prompt'=>'--Seleccione--',
              'ajax' => array(
                'url' => CController::createUrl('citiesByDepartament'), //action en el controlador
                'type' => 'POST',
                'update' => '#' . CHtml::activeId($model, 'city_id'),
              ),
            ));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'deparment_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'city_id');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-map-marker"></i>
          </div>
          <?php
          $cities=CHtml::listData(Cities::model()->findAll('city_state=1'),'city_id','city_name');
          echo $form->dropDownList($model,'city_id',$cities,array('class'=>'form-control','prompt'=>'--Seleccione--'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'city_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'wharehouse_status');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-shield"></i>
          </div><?php echo $form->dropDownList($model,'wharehouse_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'wharehouse_status',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <?php echo CHtml::button($model->isNewRecord?'Guardar':'Actualizar',array('class'=>'btn btn-block btn-success btn-lg', 'onclick' => 'send();'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">			
        <?php echo CHtml::button('Cancelar',array('class'=>'btn btn-block btn-danger btn-lg','data-toggle'=>'modal','data-target'=>'#myModalCancel'));?> 
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
       url = $("#wharehouses-form").attr('action');
       data = $("#wharehouses-form").serialize();
        
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
                        document.getElementById("wharehouses-form").reset();
                    }
                }, 2500);
                
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>

