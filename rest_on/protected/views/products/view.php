<?php
/* @var $this ProductsController */
/* @var $model Products */
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/dist/js/html2canvas.min.js');

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/bootstrap/css/bootstrap.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/dist/css/AdminLTE.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css');

use App\User\User as U;

/* @var $this ProductsController */
/* @var $dataProvider CActiveDataProvider */

$user=U::getInstance();
$visible=$user->isSupervisor;
$isAdmin=$user->isAdmin;

$this->menu = array(
  array('label'=>'Crear Producto','url'=>array('create'),'visible'=>$visible),
  array('label'=>'Actualizar Producto','url'=>array('update','id'=>$model->product_id)),
  array('label'=>($isAdmin?'Administrar':'Ver').' Producto','url'=>array('index')),
);
?>

<div class="invoice" id="section-to-print"><!-- title row -->
  <div class="row">
    <div class="col-xs-12" >
      <h2 class="page-header">
        <i class="fa fa-file-text"></i> Detalle de Producto
        <small class="pull-right">Fecha: <?php echo date('Y-m-d');?></small>
      </h2>
    </div><!-- /.col -->

    <div id="datos" style="padding: 1%;" >
      <div class="row">
        <div class="col-xs-4">
          <?php echo CHtml::label("Producto : ",'')?>
          <?php echo $model->product_description?>

        </div><!-- /.col -->

        <div class="col-xs-4 invoice-col">
          <?php echo CHtml::label("Empresa : ",'')?>
          <?php echo $model->company->company_name?>
          <!--<?php echo CHtml::textField("Empresa",$model->company->company_name,array("readonly"=>"readonly"))?>-->

        </div><!-- /.col -->

        <div class="col-xs-4 invoice-col">
          <?php echo CHtml::label("Código de Barras : ",'')?>
          <?php echo $model->product_barCode?>
          <!--	<?php echo CHtml::textField("Código de Barras",$model->product_barCode,array("readonly"=>"readonly"))?>-->

        </div><!-- /.col -->
      </div><!-- /.row -->


      <div class="row">
        <div class="col-xs-4">
          <?php echo CHtml::label("Categoría : ",'')?>
          <?php echo $model->category->category_description?>
          <!--<div class="form-group">
          <?php echo CHtml::textField("Categoría",$model->category->category_description,array("readonly"=>"readonly"))?>
          </div> -->
        </div><!-- </div> -->


        <div class="col-xs-4 invoice-col">
          <?php echo CHtml::label("Precio : ",'')?>
          <?php echo $model->product_price?>
          <!--<div class="form-group">
          <?php echo CHtml::textField("Precio",$model->product_price,array("readonly"=>"readonly"))?>
          </div> -->
        </div><!-- /.col -->

        <div class="col-xs-4 invoice-col">
          <?php echo CHtml::label("Estado : ",'')?>
          <?php
          if($model->product_status == 1){
            echo "Activo";
          }else{
            echo "Inactivo";
          }
          ?>
          <!--<?php echo CHtml::label("Estado : ",'')?>
          <div class="form-group">
          <?php echo CHtml::textField("Estado",($model->product_status == 1)?'Activo':'Inactivo',array("readonly"=>"readonly"))?>
                          
          </div> -->
        </div><!-- /.col -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-xs-4">
          <?php echo CHtml::label("IVA : ",'')?>
          <?php echo $model->product_iva?>
          <!--<div class="form-group">
          <?php echo CHtml::textField("IVA",$model->product_iva,array("readonly"=>"readonly"))?>
                          
                  </div> -->
        </div><!-- /.col -->
        <div class="col-xs-4 invoice-col">
          <?php echo CHtml::label("Unidad : ",'')?>
          <?php echo $model->unit->unit_name?>
          <!--<div class="form-group">
          <?php echo CHtml::textField("Unidad",$model->unit->unit_name,array("readonly"=>"readonly"))?>
          </div> -->
        </div><!-- /.col -->
        <div class="col-xs-4 invoice-col no-print">
          <?php echo CHtml::button('Asignar Impuestos',array('class'=>'btn btn-success','id'=>'imp'))?>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        <div class="col-xs-4 invoice-col">
          <?php echo CHtml::label("Observaciones : ",'')?>
          <?php echo $model->product_remarks?>
          <!--<div class="form-group">
          <?php echo CHtml::textField("Observaciones",$model->product_remarks,array("readonly"=>"readonly"))?>
           </div> -->
        </div><!-- /.col -->
      </div><!-- info row -->
    </div>

  </div>

  <div id="impuestos" style="display: none;">
    <div class="row">
      <div class="col-xs-12" >
        <h2 class="page-header">
          <i class="fa fa-file-text"></i> Asignar Impuestos
          <small class="pull-right">Fecha: <?php echo date('Y-m-d');?></small>
        </h2>
      </div><!-- /.col -->

      <div id="datos-taxes" style="padding: 1%;" >
        <?php $this->renderPartial('taxes',array('taxes'=>$taxes,'model'=>$model));?>
      </div>

    </div>
  </div>


  <div class="row">
    <div class="col-xs-6">
      <h2 class="page-header">
        <i class="fa fa-picture-o"></i> Imagen del Producto
      </h2>
    </div><!-- /.col -->
    <div class="col-xs-6">
      <h2 class="page-header">
        <i class="fa fa-cubes"></i> Componentes
      </h2>
    </div><!-- /.col -->
  </div><!-- info row -->
  <div class="row">
    <div class="col-xs-6">
      <div class="form-group">
        <div class="row">
          <div id="datos-image" class="clearfix" style="padding: 1%;" >
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
              <?php
              $img = ($model->product_image)?$model->product_image:'product-250x250.jpg';
              echo CHtml::image(Yii::app()->createAbsoluteUrl('/').'/themes/'.Yii::app()->theme->name.'/dist/img/'.$img,'',array('class'=>'img-thumbnail',"data-toggle"=>"tooltip","title"=>$model->product_description));
              ?>
            </div>
            <div class="col-xs-2"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="form-group">
        <div class="row">
          <div id="datos-components" style="padding: 1%;" >
            <?php
            if($compVis)
                $this->renderPartial('detail_comp',array('model'=>$comp,'prod'=>$model));
            else
                echo '<div class="col-xs-2"></div><div class="col-xs-8">'.CHtml::image(Yii::app()->theme->baseUrl.'/dist/img/'.'no_components.png','',array('class'=>'img-thumbnail',"data-toggle"=>"tooltip")).'</div><div class="col-xs-2"></div>';
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">
      <a href="#" target="_blank" class="btn btn-default printing" data-section="section-to-print"><i class="fa fa-print"></i> Imprimir</a>

      <a href="javascript:;" target="_blank" class="btn btn-primary pull-right to-canvas" style="margin-right: 5px;">
        <i class="fa fa-download"></i> Generar PDF
      </a>
    </div>
  </div>
</div>
<form id="form_save_pdf" name="form_save_pdf" target="_blank" method="post" action="<?=Yii::app()->createAbsoluteUrl('products/'.$model->product_id,['format'=>'pdf'])?>">
  <input type="hidden" name="image" id="image-to-pdf" />
</form>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/docs/js/highlight.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/dist/js/bootstrap-switch.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/bootstrap-switch/docs/js/main.js"></script>
<script type="text/javascript">
  jQuery(function($){
    $("#imp").click(function(){
      if($('#impuestos').is(":visible")) {
        $("#impuestos").hide(1000);
      }else {
        $("#impuestos").show(1000);
      }
      // make a Display: block in CSS to div
    });
    $('.to-canvas').on('click',function(){
      var invoice=$('.invoice'),
      impuestos=$('#impuestos'),
      isVisible=impuestos.css('display');
      impuestos.show();
      $('.no-print').hide();
      $('#impuestos').show();
      Modal.show('Generando archivo PDF...<br /> Debe habilitar las ventanas emergentes para poder visualizarlo.');
      html2canvas(invoice[0], {
        onrendered: function(canvas) {
          Modal.show('El achivo se ha generado correctamente. <br />Si no lo visualiza debe habilitar las ventanas emergentes.');
          $('.no-print').show();
          impuestos.css('display',isVisible);
          var form=document.form_save_pdf;
          form.image.value=canvas.toDataURL("image/png");
          form.submit();
        }
      });
    });
  });
</script>