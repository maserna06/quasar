<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/dist/js/html2canvas.min.js');


Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/bootstrap/css/bootstrap.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/dist/css/AdminLTE.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css');
/* @var $this SuppliersController */
/* @var $model CompaniesSuppliers */

use App\User\User as U;
$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

//Validate Visibility
$this->menu=array(
	array('label'=>'Crear Proveedor', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Actualizar Proveedor', 'url'=>array('update', 'id'=>$model->supplier_nit)),
  array('label'=>($isAdmin?'Administrar':'Ver').' Proveedores','url'=>array('index')),
);
?>
<section class="content">
  <div class="invoice"><!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-file-text"></i> Detalle de Proveedor
          <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
        </h2>
      </div><!-- /.col -->
    </div><!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Proveedor
        <address>
          <strong><?php echo $model->supplier_name; ?></strong><br>
          Contacto:  <?php echo $model->contact_name; ?><br>
          <br>
          Nit: <?php echo $model->supplier_nit; ?><br>
          Email: <?php echo $model->supplier_email; ?>
        </address>
      </div><!-- /.col -->
      <div class="col-sm-4 invoice-col">
        De
        <address>
          <strong>
              <?php
              if (!empty($model->city_id)) {
                  $city = Cities::model()->findByPk($model->city_id);
                  echo $city->city_name;
              } else {
                  echo "";
              }
              echo ", ";
              ?></strong>
          <?php
          if (!empty($model->deparment_id)) {
              $deparment = Departaments::model()->findByPk($model->deparment_id);
              echo $deparment->deparment_name;
          } else {
              echo "";
          }
          ?>          
          <br>
          <br>
          Direccion: <?php echo $model->supplier_address; ?><br>
          Telefono: <?php echo $model->supplier_phone; ?>
        </address>
      </div><!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Otros Datos</b><br>
        <br>
        <b>Celular:</b> <?php echo $model->supplier_phonenumber; ?><br>
        <b>Regimen Simplificado:</b> 
         <?php
          if ($model->supplier_is_simplified_regime == "1") 
            echo "Si";
          else 
            echo "No";
        ?>
        <br>
        <b>Estado:</b> 
        <?php
          if ($model->supplier_status == "1") 
            echo "Activo";
          else 
            echo "Inactivo";
        ?>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <br>
    <!-- Table row -->
    <div class="row">
      <div class="col-sm-5 invoice-col">
        <h2 class="page-header">
          <i class="fa fa-file-text"></i> Asignar Impuestos
          <small class="pull-right"> </small>
        </h2>
      </div><!-- /.col -->
      <div class="col-sm-7 invoice-col">
        <h2 class="page-header">
          <i class="fa fa-cart-plus"></i> Activar en Web
          <small class="pull-right"> </small>
        </h2>
      </div><!-- /.col -->
      <div class="col-xs-5">
        <div id="datos-taxes" style="padding: 1%;" >
            <?php $this->renderPartial('taxes', array('taxes' => $taxes, 'model' => $model)); ?>
        </div>
      </div><!-- /.col -->
      <div class="col-xs-7">
        <div id="datos-customer" style="padding: 1%;" >
        <?php
          $form = $this->beginWidget('CActiveForm', array(
              'id' => 'user-form',
              'htmlOptions' => array("class" => "form",
                  'onsubmit' => "return false;", /* Disable normal form submit */
              ),
              // Please note: When you enable ajax validation, make sure the corresponding
              // controller action is handling ajax validation correctly.
              // There is a call to performAjaxValidation() commented in generated controller code.
              // See class documentation of CActiveForm for details on this.
              'enableAjaxValidation' => true,
              'enableClientValidation' => true,
              'clientOptions' => array(
                  'validateOnSubmit' => true,
                  'validateOnChange' => true,
                  'validateOnType' => true,
              ),
                  ));
        ?>
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label>Nombre de Usuario</label>
                      <div class="input-group">
                          <div class="input-group-addon">
                              <i class="fa fa-bookmark"></i>
                          </div>
                          <?php echo CHtml::hiddenField("user_id", $model->supplier_nit); ?>
                          <?php echo $form->textField($modelUser, 'user_name', array('class' => 'form-control', 'placeholder' => 'user-name')); ?>
                      </div><!-- /.input group -->
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                      <label>Email</label>
                      <div class="input-group">
                          <div class="input-group-addon">
                              <i class="fa fa-at"></i>
                          </div>
                          <?php echo $form->textField($modelUser, 'user_email', array('class' => 'form-control', 'placeholder' => 'admin@quasarepos.com', 'value' => $model->supplier_email)); ?>
                      </div><!-- /.input group -->
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                      <label>Estado</label>
                      <div class="input-group">
                          <div class="input-group-addon">
                              <i class="fa fa-shield"></i>
                          </div>
                          <?php echo $form->dropDownList($modelUser, 'user_status', array("1" => "Activo", "0" => "Inactivo"), array('class' => 'form-control')); ?>
                      </div><!-- /.input group -->
                  </div>
              </div>
              
              <div class="col-md-12 btn_changed">
                  <div class="col-md-12">
                      <div class="form-group">            
                          <input class='btn btn-block btn-success btn-lg saveSupplier' name='saveSupplier[]' id='saveSupplier' type='button' value='Guardar' />
                      </div>
                  </div>
              </div>
          </div>
        <?php $this->endWidget(); ?>
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <br>
    <!-- this row will not appear when printing -->
      <div class="row no-print">
          <div class="col-xs-12">
            <a href="#" target="_blank" class="btn btn-default printing" data-section="section-to-print"><i class="fa fa-print"></i> Imprimir</a>
            <a href="javascript:;" target="_blank" class="btn btn-primary pull-right to-canvas" style="margin-right: 5px;">
              <i class="fa fa-download"></i> Generar PDF
            </a>
          </div>
      </div>
      <form id="form_save_pdf" name="form_save_pdf" target="_blank" method="post" action="<?=Yii::app()->createAbsoluteUrl('suppliers/'.$model->supplier_nit,['format'=>'pdf'])?>">
          <input type="hidden" name="image" id="image-to-pdf" />
      </form>
  </div>
</section>
<?php $this->renderPartial('../_modal'); ?> 

<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/docs/js/highlight.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/dist/js/bootstrap-switch.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/docs/js/main.js"></script>

<script type="text/javascript">
  jQuery(function($){

    $("#saveSupplier").on('click', function(){
      var data = $("#user-form").serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo $this->createUrl('/user/DataSupplier') ?>",
        data: data,
        success: function(data)
        {
          var datos = $.parseJSON(data);
          $("#bodyArchivos").html("<div class='col-md-12'>" + datos['mensaje'] + "</div>");
          $("#myModal").modal({keyboard: false});
          $(".modal-dialog").width("40%");
          $(".modal-title").html("Información");
          $(".modal-header").addClass("alert alert-" + datos['estado']);
          $(".modal-header").show();
          $(".modal-footer").html("");
          setTimeout(function () {
            $("#myModal").modal('hide');
            $(".modal-header").removeClass("alert alert-" + datos['estado'])
          }, 2500);
        }
      });
    });
    
    $('.to-canvas').on('click',function(){
      var invoice=$('.invoice');
      $('.no-print').hide();
      
      Modal.show('Generando archivo PDF...<br /> Debe habilitar las ventanas emergentes para poder visualizarlo.');
      html2canvas(invoice[0], {
        onrendered: function(canvas) {
          Modal.show('El achivo se ha generado correctamente. <br />Si no lo visualiza debe habilitar las ventanas emergentes.');
          $('.no-print').show();
          
          var form=document.form_save_pdf;
          form.image.value=canvas.toDataURL("image/png");
          form.submit();
        }
      });
    });
  });
</script>