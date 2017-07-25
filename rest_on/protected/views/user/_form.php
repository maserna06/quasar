<?php
use App\User\User as U;
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
$user=U::getInstance();
?>

<?php
$form=$this->beginWidget('CActiveForm',array(
  'id'=>'user-form',
  'htmlOptions' => array("class" => "form",
      'onsubmit' => "return false;", /* Disable normal form submit */
      'enctype' => 'multipart/form-data'
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
<?php echo $form->hiddenField($model,'user_emailconfirmed',array('class'=>'form-control','value'=>'0'));?>
<?php echo $form->hiddenField($model,'user_phonenumberconfirmed',array('class'=>'form-control','value'=>'0'));?>
<?php echo $form->hiddenField($model,'user_lockoutenddateutc',array('class'=>'form-control','value'=>date('Y-m-d')));?>
<?php echo $form->hiddenField($model,'user_lockoutenabled',array('class'=>'form-control','value'=>'0'));?>
<?php echo $form->hiddenField($model,'user_accessfailcount',array('class'=>'form-control','value'=>'0'));?>

<div class="col-md-12">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_id');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </div><?php echo $form->textField($model,'user_id',array('size'=>20,'maxlength'=>20,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_name');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-user"></i>
          </div><?php echo $form->textField($model,'user_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_name',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_firtsname');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-bookmark"></i>
          </div><?php echo $form->textField($model,'user_firtsname',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_firtsname',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_lastname');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-bookmark-o"></i>
          </div><?php echo $form->textField($model,'user_lastname',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_lastname',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_phone');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-phone"></i>
          </div><?php echo $form->textField($model,'user_phone',array('size'=>30,'maxlength'=>30,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_phone',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_address');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-map-signs"></i>
          </div><?php echo $form->textField($model,'user_address',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_address',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_email');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-at"></i>
          </div><?php echo $form->textField($model,'user_email',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_email',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'user_phonenumber');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-mobile"></i>
          </div><?php echo $form->textField($model,'user_phonenumber',array('size'=>20,'maxlength'=>20,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'user_phonenumber',array('class'=>'alert alert-danger'));?>
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
    <?php else : ?>
    	<div class="col-md-6">
	      <div class="form-group">
	        <label><?php echo $form->labelEx($model,'user_photo');?></label>
	        <?php echo $form->fileField($model,'user_photo',array('size'=>50,'maxlength'=>50,'class'=>'',"accept"=>"image/*"));?>
	      </div>
	    </div>
    <?php endif; ?>

	    <div class="col-md-6">
	      <div class="form-group">
	        <label><?php echo $form->labelEx($model,'user_status');?></label>
	        <div class="input-group">
	          <div class="input-group-addon">
	            <i class="fa fa-shield"></i>
	          </div><?php echo $form->dropDownList($model,'user_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control'));?>
	        </div><!-- /.input group -->
	        <br><?php echo $form->error($model,'user_status',array('class'=>'alert alert-danger'));?>
	      </div>
	    </div>

  </div>
  	<?php if($user->isSuper): ?>
	  <div class="row">
	    <div class="col-md-12">
	      <div class="form-group">
	        <label><?php echo $form->labelEx($model,'user_photo');?></label>
	        <?php echo $form->fileField($model,'user_photo',array('size'=>50,'maxlength'=>50,'class'=>'',"accept"=>"image/*"));?>
          <br><?php echo $form->error($model, 'user_photo', array('class' => 'alert alert-danger')); ?>
	      </div>
	    </div>
	  </div>
	<?php endif; ?>
  <div class="row">
    <div class="col-md-6">
      <?php if($model->isNewRecord):?>
        <div class="form-group">
          <label><?php echo $form->labelEx($model,'user_passwordhash');?></label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-asterisk"></i>
            </div><?php echo $form->passwordField($model,'user_passwordhash',array('size'=>60,'maxlength'=>60,'class'=>'form-control'));?>
          </div><!-- /.input group -->
          <br><?php echo $form->error($model,'user_passwordhash',array('class'=>'alert alert-danger'));?>
        </div>
      <?php endif;?> 
    </div>
    <div class="col-md-6">
      <?php if($model->isNewRecord):?>
        <div class="form-group">
          <label><?php echo $form->labelEx($model,'repeat_password');?></label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-asterisk"></i>
            </div><?php echo $form->passwordField($model,'repeat_password',array('size'=>60,'maxlength'=>60,'class'=>'form-control'));?>
          </div><!-- /.input group -->
          <br><?php echo $form->error($model,'repeat_password',array('class'=>'alert alert-danger'));?>
        </div>
      <?php endif;?>
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

<script>
  $("#User_user_photo").fileinput({
    allowedFileExtensions: ['jpg', 'png'],
    showUpload: false,
    maxImageWidth: 420,
    maxImageHeight: 420,
    language: "es"
  });

</script>
<?php $this->endWidget(); ?>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel'); ?>
<?php $this->renderPartial('../_modal'); ?> 

<script>
    function send(form, hasError) {
       url = $("#user-form").attr('action');
       data = $("#user-form").serialize();
       var formData = new FormData(document.getElementById("user-form"));

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
                        document.getElementById("user-form").reset();
                    }
                }, 2500);
            });
            
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>