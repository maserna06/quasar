<?php

use App\User\User as U;

/* @var $this SuppliersController */
/* @var $model Suppliers */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm',array(
  'id'=>'suppliers-form',
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
$user = U::getInstance();
$newRecord = !$user->isSuper && $model->isNewRecord && !$model->supplier_nit;
?>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_document_type');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-list-alt"></i>
          </div>
          <?php
          $document = CHtml::listData(DocumentType::model()->findAll(),'type_id','type_name');
          echo $form->dropDownList($model,'supplier_document_type',$document,array('class'=>'form-control','prompt'=>'--Seleccione--'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_document_type',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_nit');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </div><?php echo $form->textField($model,'supplier_nit',array('size'=>20,'maxlength'=>20,'class'=>'form-control'));?>				
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_nit',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_name');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-bookmark"></i>
          </div><?php echo $form->textField($model,'supplier_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_name',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'contact_name');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-child"></i>
          </div><?php echo $form->textField($model,'contact_name',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'contact_name',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_email');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-at"></i>
          </div><?php echo $form->textField($model,'supplier_email',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_email',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_phone');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-phone"></i>
          </div><?php echo $form->textField($model,'supplier_phone',array('size'=>30,'maxlength'=>30,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_phone',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_address');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-map-signs"></i>
          </div><?php echo $form->textField($model,'supplier_address',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_address',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_phonenumber');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-mobile"></i>
          </div><?php echo $form->textField($model,'supplier_phonenumber',array('size'=>20,'maxlength'=>20,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_phonenumber',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'bank_nit');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-bank"></i>
          </div>
          <?php
          $document = CHtml::listData(Banks::model()->findAll(),'bank_nit','bank_name');
          echo $form->dropDownList($model,'bank_nit',$document,array('class'=>'form-control','prompt'=>'--Seleccione--'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'bank_nit',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'price_list_id');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-list-ol"></i>
          </div>
          <?php
          $price = CHtml::listData(PriceList::model()->findAll(),'price_list_id','price_name');
          echo $form->dropDownList($model,'price_list_id',$price,array('class'=>'form-control','prompt'=>'--Seleccione--'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'price_list_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_credit_quota');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-money"></i>
          </div><?php echo $form->textField($model,'supplier_credit_quota',array('class'=>'form-control'));?>
          <span class="input-group-addon">.00</span>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_credit_quota',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_discount');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="">%</i>
          </div><?php echo $form->textField($model,'supplier_discount',array('class'=>'form-control'));?>
          <span class="input-group-addon">.00</span>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_discount',array('class'=>'alert alert-danger'));?>
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
          $departaments = CHtml::listData(Departaments::model()->findAll('deparment_state=1'),'deparment_id','deparment_name');
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
          $cities = CHtml::listData(Cities::model()->findAll('city_state=1'),'city_id','city_name');
          echo $form->dropDownList($model,'city_id',$cities,array('class'=>'form-control','prompt'=>'--Seleccione--'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'city_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_is_simplified_regime');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-circle-o"></i>
          </div><?php echo $form->dropDownList($model,'supplier_is_simplified_regime',array("0"=>"No","1"=>"Si"),array('class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_is_simplified_regime',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'supplier_status');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-shield"></i>
          </div><?php echo $form->dropDownList($model,'supplier_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'supplier_status',array('class'=>'alert alert-danger'));?>
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
       url = $("#suppliers-form").attr('action');
       data = $("#suppliers-form").serialize();
        
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
                        document.getElementById("suppliers-form").reset();
                    }
                }, 2500);
                
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>

<?php if($newRecord):?>
  <script>
    jQuery(function($){
      var $documentNumber = $('#Suppliers_supplier_nit');
      function search(){
        var documentType = $('#Suppliers_supplier_document_type').val(),
        documentNumber = $documentNumber.val();
        $.ajax({
          url: '<?=$this->createUrl('getSupplier')?>',
          method: 'post',
          dataType: 'json',
          data: {
            data: {
              document_type: documentType,
              document_number: documentNumber
            }
          },
          success: function(response){
            if(response.error) {
              showMessage(response.error);
              $documentNumber.val('');
              return false;
            }
            if(response.model) {
              for(var i in response.model) {
                if(response.model.hasOwnProperty(i)) {
                  $('#Suppliers_' + i).val(response.model[i]);
                }
              }
            }
          }
        });
      }
      $documentNumber.on('blur', search);
    });
  </script>
<?php endif;?>