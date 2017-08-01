<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/dist/js/html2canvas.min.js');


Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/bootstrap/css/bootstrap.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/dist/css/AdminLTE.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css');

use App\User\Role;
use App\User\User as U;
/* @var $this UserController */
/* @var $model User */
$user=U::getInstance();

$isAdmin=$user->isAdmin;
$visible = $user->isAdmin;
$isVendor=Role::isAssigned(Role::ROLE_VENDOR,$model->user_id);

$this->menu = array(
    array('label' => 'Crear Usuario', 'url' => array('create'), 'visible' => $visible),
    array('label' => 'Actualizar Usuario', 'url' => array('update', 'id' => $model->user_id)),
    array('label'=>($isAdmin?'Administrar':'Ver').' Usuarios', 'url'=>array('index')),
);
?>

<?php /* this->widget('zii.widgets.CDetailView', array(
  'data'=>$model,
  'attributes'=>array(
  'user_id',
  'user_name',
  'user_firtsname',
  'user_lastname',
  'user_phone',
  'user_address',
  'user_photo',
  'user_email',
  'user_emailconfirmed',
  'user_phonenumber',
  'user_phonenumberconfirmed',
  'user_passwordhash',
  'user_lockoutenddateutc',
  'user_lockoutenabled',
  'user_accessfailcount',
  'deparment_id',
  'city_id',
  'company_id',
  'user_status',
  ),
  )); */ ?>
<section class="content">
  <div class="invoice"><!-- title row -->
      <div class="row">
          <div class="col-xs-12">
              <h2 class="page-header">
                  <i class="fa fa-file-text"></i> Detalle de Usuario
                  <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
              </h2>
          </div><!-- /.col -->
      </div><!-- info row -->
      <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
              Usuario      
              <address>
                  <strong><?php echo $model->user_name; ?></strong><br>
                  <?php echo $model->user_firtsname; ?><br>
                  <?php echo $model->user_lastname; ?><br>
                  Cedula: <?php echo $model->user_id; ?><br>
                  Email: <?php echo $model->user_email; ?>
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
                  Empresa: 
                  <?php
                  if (!empty($model->company_id)) {
                      $company = Companies::model()->findByPk($model->company_id);
                      echo $company->company_name;
                  } else {
                      echo "";
                  }
                  ?>
                  <br>
                  Direccion: <?php echo $model->user_address; ?><br>
                  Telefono: <?php echo $model->user_phone; ?>
              </address>
          </div><!-- /.col -->
          <div class="col-sm-4 invoice-col">
              <b>Otros Datos</b><br>
              <br>
              <b>Activacion:</b> <?php echo $model->user_lockoutenddateutc; ?><br>
              <b>Celular:</b> <?php echo $model->user_phonenumber; ?><br>
              <b>Estado:</b> 
              <?php
              if ($model->user_status == "1") {
                  echo "Activo";
              } else {
                  echo "Inactivo";
              }
              ?>
              <br>
              <?php
              echo CHtml::button('Asignar Bodegas', array(
                'class' => 'btn btn-primary vendor-role-config',
                'style'=>$isVendor && count($bodegas)>0?'':'display:none',
                'id'=>'bod'
              ));
              if (Yii::app()->authManager->isAssigned('vendor', $model->user_id) && count($bodegas)>0 ){
              }else {
                  if(!$model->company_id){
                      echo '<div class="alert alert-danger"  style="">Usuario no tiene EMPRESA asociada.</div>';
                  } else if(count($bodegas)==0) {
                       echo '<div class="alert alert-danger"  style="">Empresa no tiene Bodegas asociadas</div>';
                  }
              }
                  ?>
          </div><!-- /.col -->
      </div><!-- /.row -->
      <?php // if (Yii::app()->authManager->isAssigned('vendor', $model->user_id) && count($bodegas)>0){ ?>
      <div id="bodegas" style="display: none;" class="vendor-role-config">
          <div class="row">
              <div class="col-xs-12" >
                  <h2 class="page-header">
                      <i class="fa fa-map-pin"></i> Asignar Bodegas
                      <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
                  </h2>
              </div><!-- /.col -->

              <div id="datos-taxes" style="padding: 1%;" >
                  <?php $this->renderPartial('bodegas', array('bodegas' => $bodegas, 'model' => $model)); ?>
              </div>

          </div>
      </div>
      <?php // } ?>

      <div class="row">
          <div class="col-xs-6">
              <h2 class="page-header">
                  <i class="fa fa-picture-o"></i> Imagen del Usuario
              </h2>
          </div><!-- /.col -->
          <div class="col-sm6 invoice-col">
              <h2 class="page-header">
                  <i class="fa fa-group"></i> Roles
              </h2>
          </div><!-- /.col -->
      </div><!-- info row -->
      <div class="row">
          <div class="col-xs-6">
              <div class="form-group">
                  <div class="row">
                      <div class="col-xs-2"></div>
                      <div class="col-xs-8">
                          <?php echo CHtml::image(Yii::app()->theme->baseUrl. '/dist/img/'.$model->user_photo, '', array('class' => 'img-thumbnail', "data-toggle" => "tooltip", "title" => $model->user_name)) ?>
                      </div>
                      <div class="col-xs-2"></div>
                  </div>
              </div>
          </div>

          <div class="col-xs-6">
            <?php echo $this->renderPartial('_roles',['model'=>$model]); ?>
          </div><!-- /.col -->
      </div><!-- /.row -->
      <hr>
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
      <form id="form_save_pdf" name="form_save_pdf" target="_blank" method="post" action="<?=Yii::app()->createAbsoluteUrl('user/'.$model->user_id,['format'=>'pdf'])?>">
          <input type="hidden" name="image" id="image-to-pdf" />
      </form>
  </div>
</section>

<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/docs/js/highlight.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/dist/js/bootstrap-switch.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/docs/js/main.js"></script>

<script>

    jQuery(function ($) {

        $('.to-canvas').on('click',function(){
          var invoice=$('.invoice'),
          bodegas=$('#bodegas'),
          isVisible=bodegas.css('display');
          bodegas.show();
          $('.no-print').hide();
          $('#bodegas').show();
          $('.no-print').hide();
          
          Modal.show('Generando archivo PDF...<br /> Debe habilitar las ventanas emergentes para poder visualizarlo.');
          html2canvas(invoice[0], {
            onrendered: function(canvas) {
              Modal.show('El achivo se ha generado correctamente. <br />Si no lo visualiza debe habilitar las ventanas emergentes.');
              $('.no-print').show();
              bodegas.css('display',isVisible);
              var form=document.form_save_pdf;
              form.image.value=canvas.toDataURL("image/png");
              form.submit();
            }
          });
        });

        $("#bod").click(function () {
            if ($('#bodegas').is(":visible")) {
                $("#bodegas").hide(1000);
            } else {
                $("#bodegas").show(1000);
            }
            // make a Display: block in CSS to div
        });
    });
</script>
