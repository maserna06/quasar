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
                    <h3 class="box-title">Traslados de Inventarios <small>:: Configuración </small></h3>
                </div>
                <br> 
                <div class="box-body" style="min-height: 500px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form">                                         
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'configTransfer-form',
                                    'htmlOptions' => array("class" => "form"),
                                    // Please note: When you enable ajax validation, make sure the corresponding
                                    // controller action is handling ajax validation correctly.
                                    // There is a call to performAjaxValidation() commented in generated controller code.
                                    // See class documentation of CActiveForm for details on this.
                                    'enableAjaxValidation' => FALSE,
                                    'enableClientValidation' => true,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                        'validateOnChange' => true,
                                        'validateOnType' => true,
                                    ),
                                ));
                                ?>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Consecutivo</label>
                                    <?php echo $form->textField($model, 'transfer_id', array('size' => 500, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Consecutivo', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Inicialice el Consecutivo para los Traslados")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Inicialice el Consecutivo para los Traslados.</small>
                                    <br><?php echo $form->error($model, 'transfer_id', array('class' => 'alert alert-danger')); ?>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Formato de Impresión</label>
                                    <?php echo $form->dropDownList($model, 'transfer_format', array("1" => "Formato Carta", "2" => "Formato Media Carta", "3" => "Formato Tirilla"), array('class' => 'form-control', 'empty' => '--Formato de Impresion--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Formato de Impresion para los Traslados")); ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Formato de Impresion para los Traslados.</small>
                                    <br><?php echo $form->error($model, 'transfer_format', array('class' => 'alert alert-danger')); ?>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bodega Entrada</label>
                                    <?php
                                    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
                                    echo $form->dropDownList($model, 'wharehouse_in', $whare, array('class' => 'form-control', 'prompt' => '--Bodega--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
                                    ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Bodega de Entrada para los Traslados.</small>
                                    <br><?php echo $form->error($model, 'wharehouse_in', array('class' => 'alert alert-danger')); ?> 
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bodega Salida</label>
                                    <?php
                                    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
                                    echo $form->dropDownList($model, 'wharehouse_out', $whare, array('class' => 'form-control', 'prompt' => '--Bodega--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
                                    ?>
                                    <small id="emailHelp" class="form-text text-muted">Seleccione Bodega de Salida para los Traslados.</small>
                                    <br><?php echo $form->error($model, 'wharehouse_out', array('class' => 'alert alert-danger')); ?> 
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
                  <h3 class="box-title">Producto Terminado <small>:: Configuracion</small></h3>
                </div>
                <br> 
                <div class="box-body" style="min-height: 500px;">
                    <div class="row">
                        <div class="col-sm-12">                       
                            <div class="form">                           
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'configFinishedProduct-form',
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
                                <?php echo $form->textField($model1, 'finished_product_id', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Consecutivo', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Inicialice el Consecutivo para los Productos Terminados")); ?>
                                <small id="emailHelp" class="form-text text-muted">Inicialice el Consecutivo para los Productos Terminados.</small>
                                <br><?php echo $form->error($model1, 'finished_product_id', array('class' => 'alert alert-danger')); ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Formato de Impresión</label>                                       
                                <?php echo $form->dropDownList($model1, 'finished_product_format', array("1" => "Formato Carta", "2" => "Formato Media Carta", "3" => "Formato Tirilla", "4" => "Formato Tirilla y Comanda"), array('class' => 'form-control', 'prompt' => '--Formato de Impresion--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Formato de Impresion para los Productos Terminados")); ?>
                                <small id="emailHelp" class="form-text text-muted">Seleccione Formato de Impresion para los Productos Terminados.</small>
                                <br><?php echo $form->error($model1, 'finished_product_format', array('class' => 'alert alert-danger')); ?>
                            </div>
                    
                            <div class="form-group">
                                <label for="exampleInputEmail1">Bodega</label>
                                <?php
                                    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
                                    echo $form->dropDownList($model1, 'wharehouse_id', $whare, array('class' => 'form-control', 'prompt' => '--Bodega--', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
                                    ?>
                                <small id="emailHelp" class="form-text text-muted">Seleccione Bodega para los Productos Terminados.</small>
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

        <!-- Miguel posada 25-07-2017  -->
        <div class="col-xs-4">
            <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Inventarios <small>:: Configuracion</small></h3>
                </div>
                <br> 
                <div class="box-body" style="min-height: 500px;">
                    <div class="row">
                        <div class="col-sm-12">                   
                            <div class="form">                           
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'configFinishedInventory-form',
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
                                <p><label for="exampleInputEmail1">Ficha Tecnica</label></p>
                                <input type="hidden" name="FinishedInventoryConfig[company_id]" id ="FinishedInventoryConfig_company_id" value="<?php echo Yii::app()->getSession()->get('empresa'); ?>">
                                <input name="FinishedInventoryConfig[handle_datasheet]" id ="FinishedInventoryConfig_handle_datasheet" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" <?php echo ($model2->handle_datasheet == 1) ? 'checked' : '';?>>
                                <p><small id="emailHelp" class="form-text text-muted">Aplica Ficha Tecnica en Productos.</small></p>
                                <br><?php echo $form->error($model2, 'handle_datasheet', array('class' => 'alert alert-danger')); ?>
                            </div>

                            <div class="form-group">
                                <p><label for="exampleInputEmail1">Manejo de Mesas</label></p>
                                <input name="FinishedInventoryConfig[manage_tables]" id ="FinishedInventoryConfig_manage_tables" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" <?php echo ($model2->manage_tables == 1) ? 'checked' : '';?>>
                                <p><small id="emailHelp" class="form-text text-muted">Manejo de mesas en Punto de Venta.</small></p>
                                <br><?php echo $form->error($model2, 'manage_tables', array('class' => 'alert alert-danger')); ?>
                            </div>

                            <div class="form-group">
                                <p><label for="exampleInputEmail1">Costo Promedio (PAP)</label></p>
                                <input name="FinishedInventoryConfig[manage_pap]" id ="FinishedInventoryConfig_manage_pap" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" <?php echo ($model2->manage_tables == 1) ? 'checked' : '';?>>
                                <p><small id="emailHelp" class="form-text text-muted">Manejo de calculo de Costo Promedio (PAP).</small></p>
                                <br><?php echo $form->error($model2, 'manage_tables', array('class' => 'alert alert-danger')); ?>
                            </div>
                           
                            <div class="form-group pull-right">  
                            <?php echo CHtml::button($model1->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success', 'onclick' => 'send(3);', 'disabled' => ($empresa == 0) ? 'disabled' : '')); ?>
                            </div>

                            <?php $this->endWidget(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</section>
<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal'); ?> 

<script>
    function send(form, hasError) {
        if (form == 1) {
            url = $("#configTransfer-form").attr('action');
            data = $("#configTransfer-form").serialize();
        } else if (form == 2){
            url = $("#configFinishedProduct-form").attr('action');
            data = $("#configFinishedProduct-form").serialize();
            //Miguel p 27-07=2017
        }else if (form == 3){
            url = $("#configFinishedInventory-form").attr('action');
            data = $("#configFinishedInventory-form").serialize();
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
                if(datos['MostOcultMenuIzq'] == 0)
                {
                    $("#left-menu-process").remove();
                }else{
                   $('<li id="left-menu-process"><a href="/yii/rest_on/process"><i class="fa fa-circle-o"></i> Procesos</a></li>').insertAfter("#categorias-menuIzq-process");
                }
                
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>