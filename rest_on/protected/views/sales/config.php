<?php
$empresa = Yii::app()->getSession()->get('empresa');
/* @var $this PurchasesController */
/* @var $model Purchases */
/* @var $form CActiveForm */
?>
<section class="content">
  <div class="row">


    <div class="col-xs-4">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Pedidos <small>:: Configuracion </small></h3>
        </div>
        <br> 
        <div class="box-body" style="min-height: 500px;">            
            
                <div class="row">
                    <div class="col-sm-12">
                        
                            <div class="form">
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'configRequest-form',
                                'htmlOptions' => array("class" => "form",
                                    'onsubmit' => "return false;", /* Disable normal form submit */
                                ),
                                // Please note: When you enable ajax validation, make sure the corresponding
                                // controller action is handling ajax validation correctly.
                                // There is a call to performAjaxValidation() commented in generated controller code.
                                // See class documentation of CActiveForm for details on this.
                                'enableAjaxValidation'=>false,
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    'validateOnChange' => true,
                                    'validateOnType' => true,
                                ),
                            )); ?>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Consecutivo</label>                                   
                                    <?php echo $form->textField($model, 'request_id', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Consecutivo', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Inicialice el Consecutivo para los Pedidos de Venta")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Inicialice el Consecutivo para los Pedidos de Venta.</small>
                                    <br><?php echo $form->error($model, 'request_id', array('class' => 'alert alert-danger')); ?>                                    
                                </div>
                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Formato de Impresión</label>                                       
                                    <?php echo $form->dropDownList($model, 'request_format', array("1" => "Formato Carta", "2" => "Formato Media Carta", "3" => "Formato Tirilla", "4" => "Formato Tirilla y Comanda"), array('class' => 'form-control', 'prompt' => '--Formato de Impresion--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Formato de Impresion para los Pedidos de Venta")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Formato de Impresion para los Pedidos de Venta.</small>
                                    <br><?php echo $form->error($model, 'request_format', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cuenta Contable</label> 
                                    <?php
                                        $type = CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name');
                                        echo $form->dropDownList($model, 'accounts_id', $type, array('class' => 'form-control', 'prompt' => '--Cuenta Contable--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Cuenta Contable"));
                                        ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Cuenta Contable para los Pedidos de Venta.</small>
                                    <br><?php echo $form->error($model, 'accounts_id', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bodega</label>
                                    <?php
                                        $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
                                        echo $form->dropDownList($model, 'wharehouse_id', $whare, array('class' => 'form-control', 'prompt' => '--Bodega--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
                                        ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Bodega para los Pedidos de Venta.</small>
                                    <br><?php echo $form->error($model, 'wharehouse_id', array('class' => 'alert alert-danger')); ?>

                                </div>
                               <div class="form-group pull-right">  
            <?php echo CHtml::button($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success', 'onclick' => 'send(1);', 'disabled' => ($empresa == 0) ? 'disabled' : '')); ?>
                                </div>

                            <?php $this->endWidget(); ?>
                            </div>     
                    </div>
                </div>
          
            </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <div class="col-xs-4">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Factura de Remision <small>:: Configuracion</small></h3>
        </div>
        <br> 
        <div class="box-body" style="min-height: 500px;">            
            
            <div class="row">
                    <div class="col-sm-12">
                       
                            <div class="form">                           
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'configReferral-form',
                                'htmlOptions' => array("class" => "form",
                                    'onsubmit' => "return false;", /* Disable normal form submit */
                                ),
                                // Please note: When you enable ajax validation, make sure the corresponding
                                // controller action is handling ajax validation correctly.
                                // There is a call to performAjaxValidation() commented in generated controller code.
                                // See class documentation of CActiveForm for details on this.
                                'enableAjaxValidation'=>false,
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    'validateOnChange' => true,
                                    'validateOnType' => true,
                                ),
                            )); ?>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Consecutivo</label>                                     
                                    <?php echo $form->textField($model1, 'referral_id', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Consecutivo', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Inicialice el Consecutivo para las Remisiones de Venta")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Inicialice el Consecutivo para las Remisiones de Venta.</small>
                                    <br><?php echo $form->error($model1, 'referral_id', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">                                                                    
                                    <label for="exampleInputEmail1">Medios de Pago</label>   
                                    <input name="ReferralConfig[referral_payment]" id ="ReferralConfig_referral_payment" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" <?php echo ($model1->referral_payment == 1) ? 'checked' : '';?>>
                                    <small id="emailHelp" class="form-text text-muted">Active los Medios de Pago.</small>     
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Formato de Impresión</label>                                       
                                    <?php echo $form->dropDownList($model1, 'referral_format', array("1" => "Formato Carta", "2" => "Formato Media Carta", "3" => "Formato Tirilla", "4" => "Formato Tirilla y Comanda"), array('class' => 'form-control', 'prompt' => '--Formato de Impresion--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Formato de Impresion para las Remisiones de Venta")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Formato de Impresion para las Remisiones de Venta.</small>
                                    <br><?php echo $form->error($model1, 'referral_format', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cuenta Contable</label>       
                                    <?php
                                        $type = CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name');
                                        echo $form->dropDownList($model1, 'accounts_id', $type, array('class' => 'form-control', 'prompt' => '--Cuenta Contable--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Cuenta Contable"));
                                        ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Cuenta Contable para las Remisiones de Venta.</small>
                                    <br><?php echo $form->error($model1, 'accounts_id', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bodega</label>
                                    <?php
                                        $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
                                        echo $form->dropDownList($model1, 'wharehouse_id', $whare, array('class' => 'form-control', 'prompt' => '--Bodega--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
                                        ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Bodega para las Remisiones de Venta.</small>
                                    <br><?php echo $form->error($model1, 'wharehouse_id', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group pull-right">  
            <?php echo CHtml::button($model1->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success', 'onclick' => 'send(2);', 'disabled' => ($empresa == 0) ? 'disabled' : '')); ?>
                                </div>

                            <?php $this->endWidget(); ?>
                            </div>

                                         
                    </div>
                </div>
                
            </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <div class="col-xs-4">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Factura de Venta <small>:: Configuracion </small></h3>
        </div>
        <br> 
        <div class="box-body" style="min-height: 500px;">
            
            <div class="row">
                    <div class="col-sm-12">
                        
                            <div class="form"> 
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'configSale-form',
                                'htmlOptions' => array("class" => "form",
                                    'onsubmit' => "return false;", /* Disable normal form submit */
                                ),
                                // Please note: When you enable ajax validation, make sure the corresponding
                                // controller action is handling ajax validation correctly.
                                // There is a call to performAjaxValidation() commented in generated controller code.
                                // See class documentation of CActiveForm for details on this.
                                'enableAjaxValidation'=>false,
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    'validateOnChange' => true,
                                    'validateOnType' => true,
                                ),
                            )); ?>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Consecutivo</label>                                     
                                    <?php echo $form->textField($model2, 'sale_id', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Consecutivo', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Inicialice el Consecutivo para las Facturas de Venta")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Inicialice el Consecutivo para las Facturas de Ventas.</small>
                                    <br><?php echo $form->error($model2, 'sale_id', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Medios de Pago</label>                                
                                    <input name="SaleConfig[sale_payment]" id ="SaleConfig_sale_payment" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" <?php echo ($model2->sale_payment == 1) ? 'checked' : '';?>>
                                    <small id="emailHelp" class="form-text text-muted">Active los Medios de Pago.</small> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Formato de Impresión</label>                                      
                                    <?php echo $form->dropDownList($model2, 'sale_format', array("1" => "Formato Carta", "2" => "Formato Media Carta", "3" => "Formato Tirilla", "4" => "Formato Tirilla y Comanda"), array('class' => 'form-control', 'prompt' => '--Formato de Impresion--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Formato de Impresion para las Facturas de Venta")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Formato de Impresion para las Facturas de Ventas.</small>
                                    <br><?php echo $form->error($model2, 'sale_format', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cuenta Contable</label> 
                                    <?php
                                        $type = CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name');
                                        echo $form->dropDownList($model2, 'accounts_id', $type, array('class' => 'form-control', 'prompt' => '--Cuenta Contable--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Cuenta Contable"));
                                        ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Cuenta Contable para las Facturas de Ventas.</small>
                                    <br><?php echo $form->error($model2, 'accounts_id', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bodega</label>
                                    <?php
                                        $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
                                        echo $form->dropDownList($model2, 'wharehouse_id', $whare, array('class' => 'form-control', 'prompt' => '--Bodega--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
                                        ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Bodega para las Facturas de Ventas.</small>
                                    <br><?php echo $form->error($model2, 'wharehouse_id', array('class' => 'alert alert-danger')); ?>
                                </div>
                                <div class="form-group pull-right">  
            <?php echo CHtml::button($model1->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success', 'onclick' => 'send();', 'disabled' => ($empresa == 0) ? 'disabled' : '')); ?>
                                </div>

                            <?php $this->endWidget(); ?>
                            </div>

                                         
                    </div>
                </div>
                
            </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    
   
  </div><!-- /.row -->
</section>
<!-- Modal para validar cancelación de formulario -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" -integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
<?php $this->renderPartial('../_modal'); ?> 
<?php if (Yii::app()->getSession()->get('empresa') == 0) { ?>
    <script>
        $("#myModal").modal('show');
        $("#myModalLabel").html("Información");
        $(".modal-body").html("No tienen ninguna Empresa asociada")
        $(".modal-footer").html("<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>")

    </script>
<?php } ?>
<script>
    function send(form, hasError) {
        if(form == 1) {
            url = $("#configRequest-form").attr('action');
            data = $("#configRequest-form").serialize();
        } else if(form == 2){
            url = $("#configReferral-form").attr('action');
            data = $("#configReferral-form").serialize();
        }else{
            url = $("#configSale-form").attr('action');
            data = $("#configSale-form").serialize();
        }
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
                $(".modal-header").addClass("alert alert-" + datos['estado']);
                $(".modal-header").show();
                $(".modal-footer").html("");
                setTimeout(function () {
                    $("#myModal").modal('hide');
                    $(".modal-header").removeClass("alert alert-" + datos['estado'])
                }, 2500);
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>
