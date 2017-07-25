<?php

use App\User\User as U;

/* @var $this ProductsController */
/* @var $model Products */
/* @var $form CActiveForm */

//Yii::app()->clientScript->registerCssFile('//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css');
$cs = Yii::app()->clientScript;
$cssCoreUrl = $cs->getCoreScriptUrl();
$cs->registerCssFile($cssCoreUrl.'/jui/css/base/jquery-ui.css');

$user = U::getInstance();
?>

<?php
  $form = $this->beginWidget('CActiveForm',array(
    'id'=>'products-form',
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
    )
  ));
?>
<div class="col-md-12">
  <div class="row">
    <?php if($user->isSuper):?>
      <div class="col-md-6">
        <div class="form-group">
          <label><?php echo $form->labelEx($model,'company_id');?></label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-industry"></i>
            </div>
            <?php
            $companies = CHtml::listData(Companies::model()->findAll('company_status=1'),'company_id','company_name');
            echo $form->dropDownList($model,'company_id',$companies,array('class'=>'form-control','prompt'=>'--Seleccione---'));
            ?>

          </div><!-- /.input group -->
          <br><?php echo $form->error($model,'company_id',array('class'=>'alert alert-danger'));?>
        </div>
      </div>
    <?php endif;?>
    <div class="col-md-<?=$user->isSuper?6:12?>">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_description');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-bookmark"></i>
          </div>
          <?php echo $form->textField($model,'product_description',array('size'=>50,'maxlength'=>50,'class'=>'form-control'));?>

        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_description',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>	

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_barCode');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </div><?php echo $form->textField($model,'product_barCode',array('size'=>12,'maxlength'=>12,'class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_barCode',array('class'=>'alert alert-danger'));?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'category_id');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-bars"></i>
          </div>
          <?php
          $category = CHtml::listData(Categories::model()->findAll('category_status=1'),'category_id','category_description');
          echo $form->dropDownList($model,'category_id',$category,array('class'=>'form-control','prompt'=>'--Seleccione---'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'category_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'unit_id');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-chevron-circle-down"></i>
          </div>
          <?php
          $unit = CHtml::listData(Unit::model()->findAll('unit_status=1'),'unit_id','unit_name');
          echo $form->dropDownList($model,'unit_id',$unit,array('class'=>'form-control','prompt'=>'--Seleccione--'));
          ?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'unit_id',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_price');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-usd"></i>
          </div><?php echo $form->textField($model,'product_price',array('class'=>'form-control','placeholder'=>'0','rel'=>'tooltip','data-toggle'=>'tooltip','title'=>"Precio con IVA incluido"));?>
          <span class="input-group-addon">.00</span>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_price',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_iva');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-subscript"></i>
          </div><?php echo $form->textField($model,'product_iva',array('class'=>'form-control','placeholder'=>'0'));?>
          <span class="input-group-addon">%</span>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_iva',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_inventory_max_days');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div><?php echo $form->textField($model,'product_inventory_max_days',array('class'=>'form-control'));?>
        </div><!-- /.input group -->
      </div>
    </div>        
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_min_stock');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-minus-square"></i>
          </div><?php echo $form->textField($model,'product_min_stock',array('class'=>'form-control'));?>
          <span class="input-group-addon">.00</span>
        </div><!-- /.input group -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_max_stock');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-plus-square"></i>
          </div><?php echo $form->textField($model,'product_max_stock',array('class'=>'form-control'));?>
          <span class="input-group-addon">.00</span>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_max_stock',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_enable');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-check"></i>
          </div><?php echo $form->dropDownList($model,'product_enable',array("1"=>"Si","0"=>"No"),array('class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_enable',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_iscomponent');?></label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-cubes"></i>
          </span>
          <?php echo $form->dropDownList($model,'product_iscomponent',array("0"=>"No","1"=>"Si"),array('class'=>'form-control'));?>
          <span class="input-group-btn" id="show-components-container" style="display:<?=$model->product_iscomponent?'table-cell':'none';?>">
            <button id="show-components" class="btn btn-primary btn-sm">Componentes</button>
          </span>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_iscomponent',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_image');?></label>
        <?php echo $form->fileField($model,'product_image',array('size'=>50,'maxlength'=>50,'class'=>'form-control',"accept"=>"image/*"));?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_status');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-shield"></i>
          </div><?php echo $form->dropDownList($model,'product_status',array("1"=>"Activo","0"=>"Inactivo"),array('class'=>'form-control'));?>
        </div><!-- /.input group -->
        <br><?php echo $form->error($model,'product_status',array('class'=>'alert alert-danger'));?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label><?php echo $form->labelEx($model,'product_remarks');?></label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-commenting"></i>
          </div><?php echo $form->textArea($model,'product_remarks',array('size'=>60,'maxlength'=>200,'class'=>'form-control'));?>
        </div><!-- /.input group -->
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

<!-- Modal para componentes -->
<?php $this->renderPartial('_modal_component',array('model'=>$model));?> 

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel');?> 
<?php $this->renderPartial('../_modal'); ?> 
<?php $this->endWidget();?>
<script>
    function send(form, hasError) {
       url = $("#products-form").attr('action');
       data = $("#products-form").serialize();
       var formData = new FormData(document.getElementById("products-form"));

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
                        document.getElementById("products-form").reset();
                    }
                }, 2500);
            });

        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>

<script>
  jQuery(function($){
    var $select = $('#Products_product_iscomponent'),
    $table = $('#tablaproductos tbody'),
    productId =<?=(int)$model->product_id?>,
    $producto = $('#producto-autocomplete'),
    $addProductBtn = $('.btn-add-product'),
    $showComponents = $('#show-components'),
    $saveBtn = $('#saveBtn'),
    $errorDiv = $('#div-errores'),
    $showComponentsContainer = $('#show-components-container'),
    units = [],
    unitsRelations = [],
    components = [],
    template = null,
    unitSelect = null,
    currentComponentSelected = null
    ;

    $producto.autocomplete({
      source: function(request, response){
        $.ajax({
          url: '<?=$this->createUrl('autocomplete')?>',
          method: 'post',
          data: {
            term: request.term
          },
          dataType: 'json',
          success: function(data){
            response(data);
          }
        });
      },
      focus: function(e, ui){
        $producto.val(ui.item.product_name);
        return false;
      },
      select: function(e, ui){
        $producto.val(ui.item.product_name);
        currentComponentSelected = ui.item;
        return false;
      }
    })
    .autocomplete("instance")._renderItem = function(ul, item){
      return $('<li />')
      .text(item.product_name)
      .appendTo(ul);
    };

    $('form').keypress(function(e){
      if(e == 13) {
        return false;
      }
    });
    $('input').keypress(function(e){
      if(e.which == 13) {
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

    function getUnitsSelect(component){
      var unitSelect = $('<select name="component[und][]" class="unit" />'),
      isRelation = unitsRelations[component.unit_id],
      componentUnit = {};
      for(var i in units) {
        if(units.hasOwnProperty(i)) {
          var unit = units[i];
          if(unit.id == component.unit_id) componentUnit = unit;
          if(isRelation) {
            if($.inArray(unit.id, isRelation) >= 0 || unit == componentUnit) {
              var option = $('<option />').val(unit.id).text(unit.name);
              unitSelect.append(option);
            }
          }

        }
      }
      if(!isRelation && componentUnit) {
        var option = $('<option />').val(componentUnit.id).text(componentUnit.name);
        unitSelect.append(option);
      }

      unitSelect.on('change', function(){
        if($(this).val() == '') {
          $(this).addClass('error-comp');
          $errorDiv.show(100);
        }else {
          $(this).removeClass('error-comp');
//            validateComponents(true);
        }
      });
      return unitSelect;
    }

    function componentExists(component){
      if(components.length) {
        for(var i in components) {
          if(components.hasOwnProperty(i)) {
            var c = components[i];
            if(c.product_id == component.product_id) return true;
          }
        }
      }
      return false;
    }

    function drawComponent(component){
      component = component || {};
      if(component.drawed) return false;
      component.drawed = true;

      component.quantity = component.quantity || '';
      component.unit_id = component.unit_id || '';

      var cTemplate = $(template),
      select = getUnitsSelect(component),
      index = components.indexOf(component);
      if(index == -1) {
        components.push(component);
      }

      cTemplate
      .find('.product').text(component.name).end()
      .find('.product_id').val(component.product_id).end()
      .find('.units').append(select);
      cTemplate
      .find('.unit').val(component.unit_id).end()
      .find('.quantity').val(component.quantity).on('keyup', function(){
        if(isNaN($(this).val()) || $(this).val() == '') {
          $(this).addClass('error-comp');
        }else {
          $(this).removeClass('error-comp');
        }
      }).on('blur', function(){
        if($(this).hasClass('error-comp')) $errorDiv.show(300);
        else $errorDiv.hide(100);
      }).end()
      .find('.remove').on('click', function(e){
        e.preventDefault();
        cTemplate.remove();
        components.splice(components.indexOf(component), 1);
      });
      $table.append(cTemplate);

    }
    function drawComponents(){
      if(components.length) {
        for(var i in components) {
          if(components.hasOwnProperty(i)) {
            drawComponent(components[i]);
          }
        }
      }
      $('#modalComp').modal({
        keyboard: false,
        backdrop: false
      });
      $(".modal-dialog").width("50%");
    }

    function loadProductComponents(e){
      if(parseInt($(this).val()) == 0) {
        $showComponentsContainer.css({display: 'none'});
        return false;
      }else {
        $showComponentsContainer.css({display: 'table-cell'});
      }
      if($(this).val() == 1 && components.length == 0) {
        $.ajax({
          url: '<?=Yii::app()->createUrl('products/components',['id'=>(int)$model->product_id])?>',
          method: 'post',
          dataType: 'json',
          success: function(response){
            components = response.components || [];
            units = response.units || [];
            unitsRelations = response.unitsRelations || [];
            template = response.template || '';
            drawComponents();
          }
        });
      }else if($(this).val() == 1) {
        drawComponents();
      }
    }
    $showComponents.on('click', function(e){
      e.preventDefault();
      $select.trigger('change');
    });
    $select.on('change', loadProductComponents);

    $addProductBtn.on('click', function(e){
      e.preventDefault();
      if(!currentComponentSelected) return false;

      var productId = currentComponentSelected.product_id,
      productName = currentComponentSelected.product_name,
      component = {
        product_id: productId,
        name: productName,
        unit_id: currentComponentSelected.unit_id
      };

      $producto.val('');
      currentComponentSelected = null;
      if(componentExists(component)) return false;
      drawComponent(component);

    });

    /**
     * Validate components
     * @param {event} e Evento, si es true indica que viene desde un evento de select o input
     * @returns {void}
     */
    function validateComponents(e){
      var error = false;
      $table.find('.unit, .quantity').each(function(){
        if($(this).val() == '' || parseInt($(this).val()) == 0) {
          $(this).addClass('error-comp');
          error = true;
        }else {
          $(this).removeClass('error-comp');
        }
      });
      if(!error) {
        $("#div-errores").hide(100);
        if(e != true) $('#modalComp').modal('hide');
      }else {
        $("#div-errores").show(300);
      }
    }
    $saveBtn.on('click', validateComponents);
  });
</script>


