<?php
echo CHtml::hiddenField("confirmacion", (Yii::app()->getSession()->get('confirmacion')) ? Yii::app()->getSession()->get('confirmacion') : 0);
Yii::app()->getSession()->remove('confirmacion');

use App\User\Role;
use App\User\User as U;

/* @var $this UserController */
/* @var $model User */
$user = U::getInstance();

$visible = $user->isAdmin;
$isVendor = Role::isAssigned(Role::ROLE_VENDOR, Yii::app()->user->id);
$empresa = Yii::app()->getSession()->get('empresa');
/* @var $this SalesController */
/* @var $model Sales */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sales-form',
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
    ),
        ));
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12 pull-left" id="movimientos">
        <div class="panel panel-default height">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-7 col-md-7 col-lg-7">
                        <input class="form-control" placeholder="Buscar Producto …" autofocus="autofocus" name="" id="findProduct" type="text" style="border-color: transparent;">                      
                    </div>
                    <div class="col-xs-1 col-md-1 col-lg-1">
                        <div class="row">    
                            <div class="col-md-12">
                                <a href="#" class="pull-center " id="viewProducts"><i class="fa fa-cart-plus" title="Ver Productos" <?= ($empresa == 0) ? 'disabled' : '' ?>></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 col-md-1 col-lg-1">
                        <div class="row">    
                            <div class="col-md-12">
                                <a href="#" class="pull-center " id="reload"><i class="fa fa-refresh" title="Ultimo Movimiento"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 col-md-1 col-lg-1">
                        <div class="row">    
                            <div class="col-md-12">
                                <a href="#" class="pull-center " id="download"><i class="fa fa-download" title="Descarga de Documentos"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 col-md-1 col-lg-1">
                        <div class="row">    
                            <div class="col-md-12">
                                <a href="#" class="pull-center " id="newClient"><i class="fa fa-user-plus" title="Cliente Nuevo"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 col-md-1 col-lg-1">
                        <div class="row">    
                            <div class="col-md-12">
                                <a href="#" class="pull-right false" id="general"><i class="fa fa-server" title="Datos Generales"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="alert alert-danger" id="div-errores-store" style="display: none;">Por favor valide que selecciono por lo menos un producto y diligencie todos los datos en rojo.</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div style="max-height: 500px; min-height: 300px; overflow-y: scroll;">
                                <table class="table table-bordered" id="tablaproductos-store">
                                    <thead>
                                        <tr>
                                            <td><strong>Producto</strong></td>
                                            <td class="text-center"><strong>Bodega</strong></td>
                                            <td class="text-center"><strong>Cantidad</strong></td>
                                            <td class="text-center"><strong>Unidad</strong></td>
                                            <td class="text-center"><strong>Precio</strong></td>
                                            <td class="text-center"><strong>Total</strong></td>
                                            <td class="text-center"></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <table class="table table-condensed">
                                <tbody> 
                                    <!-- TBODY -->                                           
                                    <tr>
                                        <td></td>                                                    
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>                                                   
                                    </tr>                                            
                                    <tr>                                                
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow"></td>
                                        <td class="highrow text-right"><strong>Bruto</strong></td>
                                        <td class="highrow text-right" id="valorBruto">$0.00</td>
                                        <?php echo $form->hiddenField($model, 'sale_total', array('class' => 'form-control')); ?>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-right"><strong>Impuestos</strong></td>
                                        <td class="emptyrow text-right" id="valorImp">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-right" ><strong>Descuentos</strong></td>
                                        <td class="emptyrow text-right" id="valorDes">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
                                        <td class="emptyrow text-right"><strong>Neto</strong></td>
                                        <td class="emptyrow text-right" id="valorTotal">$0.00</td>
                                        <?php echo $form->hiddenField($model, 'sale_net_worth', array('class' => 'form-control')); ?>
                                    </tr>
                                    <tr>
                                        <td class="emptyrow text-center" colspan="6"></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <?php
                        echo CHtml::hiddenField("num_registros", 0);
                        echo CHtml::hiddenField("num_real", 0);
                        echo CHtml::hiddenField("taxCustom", 0);
                        echo CHtml::hiddenField("disCustom", 0);
                        echo CHtml::hiddenField("detail", ($datos['products']) ? $datos['products'] : 0);
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">                                
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-at"></i>
                            </div>
                            <input class="form-control" value="Factura por email" type="text" readonly="readonly">    
                            <span class="input-group-btn">
                                <input name="send_mail" id ="send_mail" class="form-control" type="checkbox" data-toggle="toggle" data-on="Enviar" data-off="No Enviar" data-onstyle="success" data-offstyle="danger">
                            </span>
                        </div>
                    </div>
                </div>
                <?php if ($datos['saleConfig']->sale_payment == 1) { ?>
                    <br>
                    <div class="row">
                        <div class="col-md-9">                                
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-credit-card"></i>
                                </div><input class="form-control" value="Medios de Pago" type="text" readonly="readonly">      
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button name="button" type="button" class="btn btn-block btn-default medios-pago">Detallar</button>
                        </div>
                    </div>
                <?php } ?>
                <br>                        
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <button name="button" type="button" id="savePen" class="btn btn-block btn-default btn-lg">Pendiente</button>
                    </div>
                    <div class="col-md-3">
                        <?php echo CHtml::button('Pagada', array('id' => 'saveComp', 'class' => 'btn btn-block btn-primary btn-lg')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4 col-lg-4 datos-generales" style="display: none;" id="datos-generales">
        <div class="panel panel-default height">
            <div class="panel-heading">Datos Generales</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <label><?php echo $form->labelEx($model, 'sale_date'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'sale_date',
                                'language' => 'es',
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => 'readonly',
                                    'class' => 'form-control',
                                    'size' => '10', // textField size
                                    'maxlength' => '10', // textField maxlength
                                    'value' => ($model->sale_date) ? $model->sale_date : date('Y-m-d'),
                                ),
                            ));
                            ?>
                        </div>
                    </div>                            
                </div>
                <!--<br>
                <div class="row">                           
                    <div class="col-md-12">
                        <label><?php echo $form->labelEx($model, 'request_id'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clone"></i>
                            </div>
                            <?php
                            $order = CHtml::listData(Requests::model()->findAll('request_status = 1 and company_id = ' . Yii::app()->getSession()->get('empresa')), 'request_id', 'request_consecut');
                            echo $form->dropDownList($model, 'request_id', $order, array('class' => 'form-control request', 'prompt' => '--Seleccione--'));
                            ?> 
                        </div>
                    </div>                          
                </div>-->
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label><?php echo $form->labelEx($model, 'user_id'); ?></label>                               
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div><?php $users = User::model()->findByPk(Yii::app()->user->id); ?>                                    
                            <?php
                            echo $form->textField($model, 'user_id', array('readonly' => 'readonly', 'class' => 'form-control', 'value' => $users->user_firtsname . ' ' . $users->user_lastname));
                            ?>
                            <?php echo $form->hiddenField($model, 'sale_status', array('class' => 'form-control', 'value' => '1')); ?>
                        </div>
                    </div>                            
                </div>
                <br>
                <div class="row">                           
                    <div class="col-md-12">
                        <label><?php echo $form->labelEx($model, 'customer_nit'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-child"></i>
                            </div>
                            <?php
                            echo $form->dropDownList($model, 'customer_nit', CustomersExtend::customerCompany(), array('class' => 'form-control customer', 'prompt' => '--Seleccione--'));
                            ?> 
                        </div>
                    </div>                          
                </div>
                <br>
                <div class="row">                           
                    <div class="col-md-12">
                        <label><?php echo $form->labelEx($model, 'accounts_id'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-money"></i>
                            </div>
                            <?php
                            $account = CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name');
                            echo $form->dropDownList($model, 'accounts_id', $account, array('class' => 'form-control', 'prompt' => '--Seleccione--', 'options' => array($datos['saleConfig']->accounts_id => array('selected' => true))));
                            ?>   
                        </div>
                    </div>                          
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label><?php echo $form->labelEx($model, 'sale_remarks'); ?></label>                                
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-sticky-note-o"></i>
                            </div>
                            <?php echo $form->textArea($model, 'sale_remarks', array('size' => 60, 'maxlength' => 500, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .height {
        min-height: 200px;
    }

    .iconbig {
        font-size: 77px;
    }

    .table > tbody > tr > .emptyrow {
        border-top: none;
    }

    .table > thead > tr > .emptyrow {
        border-bottom: none;
    }

    .table > tbody > tr > .highrow {
        border-top: 3px solid;
    }
</style>

<?php $this->endWidget(); ?>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal'); ?> 
<?php $this->renderPartial('/products/_modal_component', array('model' => $model)); ?> 

<?php 
#if (Yii::app()->authManager->isAssigned('vendor', Yii::app()->user->id) || $datos['findWharehouse'] == 0) 
if ($datos['findWharehouse'] == 0) {
    Yii::app()->clientScript->registerScript('test', "
            $('#sales-form').find('input, textarea, button, select').attr('disabled', 'disabled');
            $('#sales-form').find('a').removeAttr('onclick');
            errorWharehouse();
            function newClient (){
            }
            "
    );
}

if (Yii::app()->getSession()->get('empresa') == 0) { ?>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $("#myModal").modal('show');
        $("#myModalLabel").html("Información");
        $("#bodyArchivos").html("<p style='padding-left:15px;'>No tienen ninguna Empresa asociada</p>");
        $(".modal-footer").html("<button type='button' class='btn btn-danger btn-lg' data-dismiss='modal'>Cancelar</button>");
        //$('#newProd').bind('click', false);
    </script>
<?php } ?>

<script>
    /*Scripts viewModal.php*/
    function pasar(id) {
        var accion = $('#a-' + id).attr('class');
        if (accion == 'add-true') {
            $('#div-prod-' + id).appendTo('#lista_final');
            $('#a-' + id).html('<b style="color:red">Eliminar</b>');
            $('#a-' + id).removeClass('add-true');
            $('#a-' + id).addClass('add-false');
        }
        if (accion == 'add-false') {
            var padre = $('a#a-' + id).siblings('input#padre').val();
            $('#div-prod-' + id).appendTo('#padre-' + padre);
            $('#a-' + id).html('<b >Seleccionar</b>');
            $('#a-' + id).removeClass('add-false');
            $('#a-' + id).addClass('add-true');
        }
    }
    function jsCalculaTotal() {
        $(".final input").each(function () {
            if ($(this).attr('id') != 'padre') {
                var idProd = $(this).val();
                addProd(idProd);
            }
        })
        $("#myModal").modal('hide');
    }
    /***/
    function errorWharehouse() {
        $('#myModal').modal('show');
        $('.modal-title').html('Información');
        $('#bodyArchivos').html("<p style='padding-left:15px;'>No tienen ninguna bodega asociada, por favor contacte con el administrador.</p>");
        $('.modal-footer').html("<button type='button' class='btn btn-danger btn-lg' data-dismiss='modal'>Cerrar</button>");
    }
    function vaciar() {
        $('#findProduct').val('');
    }
    function newCustomer(dato) {
        $(".customer").load("<?= Yii::app()->baseUrl ?>/customers/customerbycompany", function (response, status, xhr) {
            $(".customer").val(dato);
        });
    }
    
    //Call View Payment
    $('.medios-pago').click(function () {
         //Call myModal with Structure Config
        $("#bodyArchivos").html('');
        $.ajax({
            url: "<?php echo $this->createUrl('/banks/modalPayment') ?>",
            success: function (result) {
                $("#bodyArchivos").html(result);                
                $("#myModal").modal({keyboard: false});
                $(".modal-dialog").width("50%");
                $('.modal-header').addClass('btn-primary');
                $(".modal-title").html("PAGAR");
                $(".modal-footer").html('');
            }
        });
    });

    function detalleRequest(myArr) {
        var d = document;
        var container = d.getElementById('tablaproductos-store');
        var next_inc = Number($("#num_registros").val());
        var real = Number($("#num_real").val());
        for (i = 0; i < myArr.length; i++) {
            next_inc = next_inc + 1;
            real = real + 1
            var tr = d.createElement('tr');
            tr.id = 'trprod' + next_inc;
            tr.className = 'lineProduct';
            container.appendChild(tr);
            var iden = 'trprod' + next_inc;
            $('#' + iden).load("<?= Yii::app()->baseUrl ?>/requests/detailView?id_detail=" + myArr[i] + '&cantidad=' + next_inc, function (response, status, xhr) {
                if (response == '') {
                    container.removeChild(tr);
                    next_inc = next_inc - 1;
                    real = real - 1;
                }
                $("#num_registros").val(next_inc);
                $("#num_real").val(real);
                bruto();
            });
        }
        // customer();
    }
    function detalleSales(myArr) {
        var d = document;
        var container = d.getElementById('tablaproductos-store');
        var next_inc = Number($("#num_registros").val());
        var real = Number($("#num_real").val());
        for (i = 0; i < myArr.length; i++) {
            next_inc = next_inc + 1;
            real = real + 1
            var tr = d.createElement('tr');
            tr.id = 'trprod' + next_inc;
            tr.className = 'lineProduct';
            container.appendChild(tr);
            var iden = 'trprod' + next_inc;
            $('#' + iden).load("<?= Yii::app()->baseUrl ?>/sales/detailView?id_detail=" + myArr[i] + '&cantidad=' + next_inc, function (response, status, xhr) {
                if (response == '') {
                    container.removeChild(tr);
                    next_inc = next_inc - 1;
                    real = real - 1;
                }
                $("#num_registros").val(next_inc);
                $("#num_real").val(real);
                bruto();
            });
        }
        customer();
    }

    function viewAlert(datos) {
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
        }, 4000);
    }
</script>
<?php if (Yii::app()->getSession()->get('empresa') == 0) { ?>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $("#myModal").modal('show');
        $("#myModalLabel").html("Información");
        $("#bodyArchivos").html("<p style='padding-left:15px;'>No tienen ninguna Empresa asociada</p>");
        $(".modal-footer").html("<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>");
    //$('#newProd').bind('click', false);
    </script>
<?php } ?>



<script>
    jQuery(function ($) {
        $('.customer').on('change', customer);
        $('#viewProducts').on('click', viewProducts);
        $('#newClient').on('click', newClient);
        var detail = $('#detail').val();
        var confirmacion = $('#confirmacion').val();
        if (detail != 0) {
            var myArr = $.parseJSON(detail);
            detalleSales(myArr);
        }

        if (confirmacion != 0) {
            var datos = $.parseJSON(confirmacion);
            viewAlert(datos)
        }

        $('#general').on('click', function (e) {
            e.preventDefault();
            var activo = $(this).hasClass('false');
            if (activo) {
                $(this).removeClass('false');
                $('#datos-generales').show(1500);
                $('#movimientos').switchClass("col-md-12 col-lg-12", "col-md-8 col-lg-8", 1000, "easeInOutQuad");
            } else {
                $(this).addClass('false');
                $('#datos-generales').hide(500);
                $('#movimientos').switchClass("col-md-8 col-lg-8", "col-md-12 col-lg-12", 1500, "easeInOutQuad");
            }

        });


        $('#tablaproductos-store').on('click', '.component', function () {
            var $table = $('#tablaproductos tbody'),
                    components = [],
                    $producto = $('#producto-autocomplete'),
                    $addProductBtn = $('.btn-add-product'),
                    $saveBtn = $('#saveBtn'),
                    $errorDiv = $('#div-errores'),
                    productId = null,
                    currentComponentSelected = null
                    ;
            $table.html('');
            $('#tablaproductos').on('keyup', '.quantity', function () {
                if (isNaN($(this).val()) || $(this).val() == '') {
                    $(this).addClass('error-comp');
                } else {
                    $(this).removeClass('error-comp');
                }
            }).on('blur', '.quantity', function () {
                var $errorDiv = $('#div-errores');
                if ($(this).hasClass('error-comp'))
                    $errorDiv.show(300);
                else
                    $errorDiv.hide(100);
            }).on('change', '.quantity', function () {
                var datosAct = $(this).parents('tr').find('.product').val();
                datosAct = $.parseJSON(datosAct);
                deleteArray(datosAct);
                datosAct.quantity = $(this).val();
                components.push(datosAct);
            }).on('change', '.unit', function () {
                var datosAct = $(this).parents('tr').find('.product').val();
                datosAct = $.parseJSON(datosAct);
                deleteArray(datosAct);
                datosAct.unit_id = $(this).val();
                components.push(datosAct);
            }).on('click', '.remove', function (e) {
                e.preventDefault();
                var id = $(this).siblings('.product').val();
                id = $.parseJSON(id);
                deleteArray(id);
                $(this).parents('tr').remove();
            });
            productId = $(this).children('input').attr('id');
            productId = productId.split('_')[1];
            components = $.parseJSON($(this).children('input').val());
            $('#modalComp').modal();
            $(".modal-footer").html("");
            $(".modal-dialog").width("50%");

            for (var i in components) {
                if (components.hasOwnProperty(i)) {
                    drawComponent(components[i]);
                }
            }
            $producto.autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '<?= $this->createUrl('/products/autocomplete') ?>',
                        method: 'post',
                        data: {
                            term: request.term
                        },
                        dataType: 'json',
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                focus: function (e, ui) {
                    $producto.val(ui.item.product_name);
                    return false;
                },
                select: function (e, ui) {
                    $producto.val(ui.item.product_name);
                    currentComponentSelected = ui.item;
                    return false;
                }
            })
                    .autocomplete("instance")._renderItem = function (ul, item) {
                return $('<li />')
                        .text(item.product_name)
                        .appendTo(ul);
            };


            //1
            $addProductBtn.on('click', function (e) {
                e.preventDefault();
                if (!currentComponentSelected)
                    return false;

                var productId = currentComponentSelected.product_id,
                        productName = currentComponentSelected.product_name,
                        component = {
                            product_id: productId,
                            name: productName,
                            unit_id: currentComponentSelected.unit_id
                        };
                $producto.val('');
                currentComponentSelected = null;
                if (componentExists(component))
                    return false;
                drawComponent(component);

            });
            //2
            function componentExists(component) {
                if (components.length) {
                    for (var i in components) {
                        if (components.hasOwnProperty(i)) {
                            var c = components[i];
                            if (c.product_id == component.product_id)
                                return true;
                        }
                    }
                }
                return false;
            }

            //3
            function drawComponent(component) {

                component.quantity = component.quantity || '';
                component.unit_id = component.unit_id || '';

                var select = getUnitsSelect(component);
                if (!componentExists(component))
                    components.push(component);
                var $tr = $('<tr/>'),
                        tdProd = $('<td/>'),
                        tdUnit = $('<td/>', {'class': 'units'}),
                        tdQuantity = $('<td/>', {'align': 'center'}),
                        tdRemove = $('<td/>', {'align': 'center'}),
                        datos = JSON.stringify(component);
                tdProd.append($('<div/>').html(component.name));
                tdUnit.append(select);
                tdQuantity.append($('<input/>', {'style': 'text-align: center; width: 50px;', 'class': 'quantity', 'value': component.quantity}));
                tdRemove.append($('<a/>', {'href': '#', 'class': 'remove'}).append($('<i/>', {'class': 'fa fa-times'})));
                tdRemove.append($('<input/>', {'class': 'product', 'value': datos, 'type': 'hidden'}));
                $tr.append(tdProd, tdQuantity, tdUnit, tdRemove);
                $table.append($tr);

            }

            function deleteArray(component) {

                for (i = 0; i < components.length; i++) {
                    if (components[i].product_id == component.product_id) {
                        components.splice(i, 1);
                    }
                }
            }
            function getUnitsSelect(component) {
                var unitSelect = $('<select name="component[und][]" class="unit" />');
                unitSelect.load("<?= Yii::app()->baseUrl ?>/unit/unitRelations?unit_id=" + component.unit_id, function () {
                });

                unitSelect.on('change', function () {
                    if ($(this).val() == '') {
                        $(this).addClass('error-comp');
                        $errorDiv.show(100);
                    } else {
                        $(this).removeClass('error-comp');
//            validateComponents(true);
                    }
                });
                return unitSelect;
            }

            /**
             * Validate components
             * @param {event} e Evento, si es true indica que viene desde un evento de select o input
             * @returns {void}
             */
            function validateComponents(e) {
                var error = false;
                $table.find('.unit, .quantity').each(function () {
                    if ($(this).val() == '' || parseInt($(this).val()) == 0) {
                        $(this).addClass('error-comp');
                        error = true;
                    } else {
                        $(this).removeClass('error-comp');
                    }
                });
                if (!error) {
                    $("#div-errores").hide(100);
                    if (e != true) {
                        $('#component_' + productId).val(JSON.stringify(components))
                        $('#modalComp').modal('hide');
                    }
                } else {
                    $("#div-errores").show(300);
                }
            }
            $saveBtn.on('click', validateComponents);

        });

        /////////////////////////////////////////////////////////
        /////////////////// DETAILS PRODUCTS ///////////////////
        ///////////////////////////////////////////////////////
        function viewProducts(e) {
            e.preventDefault();
            $("#bodyArchivos").html('');
            $.ajax({
                url: "<?php echo $this->createUrl('/requests/viewproducts') ?>",
                success: function (result) {
                    $("#bodyArchivos").html(result);
                    $("#myModal").modal({keyboard: false});
                    $(".modal-dialog").width("80%");
                    $(".modal-title").html("Ver Productos");
                    $(".modal-footer").html("<div><div class='col-md-6'><div class='form-group'><input class='btn btn-block btn-primary btn-lg' onclick='jsCalculaTotal()' name='yt1' type='button' value='Guardar' /></div></div><div class='col-md-6'><div class='form-group'><input class='btn btn-block btn-danger btn-lg' data-dismiss='modal' type='button' name='yt1' value='Cancelar' /></div></div></div>");
                }
            });
        }


        function newClient(e) {
            e.preventDefault();
            $("#bodyArchivos").html('');
            $.ajax({
                url: "<?php echo $this->createUrl('/customers/fastCustomers') ?>",
                success: function (result) {
                    
                    $("#bodyArchivos").html(result);
                    jQuery.noConflict(); 
                    $("#myModal").modal({keyboard: false});
                    $(".modal-dialog").width("60%");
                    $(".modal-title").html("Crear Cliente");
                    $(".modal-footer").html("");
                }
            });
        }
        
        (function ($) {
            var $project = $('#findProduct');
            var projects = function (request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('/products/autorequest') ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            };
            $project.autocomplete({
                width: 320,
                max: 4,
                highlight: false,
                scroll: true,
                scrollHeight: 300,
                minLength: 0,
                source: projects,
                select: function (e, ui) {
                    var p = ui['item']['value'];
                    var res = p.split(" ");
                    $project.val('');
                    if (p != "") {
                        addProd(res[0]);
                    }
                },
                close: function (event, ui) {
                    vaciar()
                }
            });
            $project.data("ui-autocomplete")._renderItem = function (ul, item) {
                var $li = $('<li>'),
                        $img = $('<img>');
                $img.attr({
                    width: '50px',
                    high: '50px',
                    class: 'espacio img-redonda',
                    src: '<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/' + item.icon,
                    alt: item.label
                });
                $b = $('<b>');
                $b.attr({
                    class: 'pull-right price-autoc',
                });
                $li.attr('data-value', item.label);
                $li.append('<a>');
                $li.find('a').append($img).append(item.label).append($b);
                $li.find('b').append(item.price);
                return $li.appendTo(ul);
            };
        })(jQuery);
        /*
         * Cargar pedidos
         */
        $(".request").change(function () {
            limpiar();
            var id = $(".request").val();
            if (id > 0) {
                $.ajax({
                    method: "POST",
                    url: "<?php echo $this->createUrl('/requests/request') ?>",
                    data: {id: id},
                    success: function (result) {
                        var datos = $.parseJSON(result);
                        $('#Referrals_accounts_id').val(datos['cuenta']);
                        $('.customer').val(datos['cliente']);
                        $('#Referrals_referral_remarks').val(datos['obs']);
                        customer();
                    }
                });
                $.ajax({
                    method: "POST",
                    url: "<?php echo $this->createUrl('/requests/requestdetail') ?>",
                    data: {id: id},
                    success: function (result) {
                        var myArr = $.parseJSON(result);
                        if (myArr.length > 0) {
                            detalleRequest(myArr);
                        }
                    }
                });
            }
        });
        /*
         * Función para limpiar formulario cuando se seleccion pedido
         */
        function limpiar() {
            $('#tablaproductos-store').html('<thead><tr><td class="text-center"><strong>Producto</strong></td><td class="text-center"><strong>Bodega</strong></td><td class="text-center"><strong>Cantidad</strong></td><td class="text-center"><strong>Unidad</strong></td><td class="text-center"><strong>Precio</strong></td><td class="text-center"><strong>Total</strong></td><td class="text-center"></td></tr></thead>');
            $("#num_registros").val(0);
            $("#num_real").val(0);
            $("#Referrals_referal_remarks").val('');
            $("#Referrals_customer_nit").val('');
            $("#taxSup").val(0);
            $("#disSup").val(0);
            $('#valorBruto').html('$ 0');
            $('#valorImp').html('$ 0');
            $('#valorDes').html('$ 0');
            $('#valorTotal').html('$ 0');
        }
    });
    function BorrarCampo(iteracion) {
        var container = document.getElementById('tablaproductos-store');
        var tr = document.getElementById("trprod" + iteracion);
        container.removeChild(tr);
        var next_inc = container.getElementsByTagName('tr').length - 1;
        $("#num_real").val(next_inc);
        bruto();
    }
    function addProd(idprod) {
        var d = document;
        var container = d.getElementById('tablaproductos-store');
        var next_inc = Number($("#num_registros").val());
        var real = Number($("#num_real").val());

        next_inc = next_inc + 1;
        real = real + 1
        d.getElementById('num_registros').value = next_inc
        var tr = d.createElement('tr');
        tr.id = 'trprod' + next_inc;
        tr.className = 'lineProduct';
        container.appendChild(tr);
        var iden = 'trprod' + next_inc;
        $('#' + iden).load("<?= Yii::app()->baseUrl ?>/products/productstore?id_prod=" + idprod + '&cantidad=' + next_inc, function (response, status, xhr) {
            if (response == '') {
                container.removeChild(tr);
                next_inc = next_inc - 1;
                real = real - 1;
            }
            $('#' + iden).find('input.calcular').on('keyup mouseup', function () {
                calcular(this);
            });
            bruto();
        });
        $("#num_registros").val(next_inc);
        $("#num_real").val(real);
    }

    function calcular(dato) {
        var idProd = dato.id;
        idProd = idProd.split("-");
        var cant = $('#cant-' + idProd[1]).val();
        var valor = $('#price-' + idProd[1]).val();
        var total = numeral(cant * valor).format('0,0');
        $('#total-' + idProd[1]).val(total);
        bruto();
    }
    function bruto() {
        var next_inc = Number($("#num_registros").val());
        var real = Number($("#num_real").val());
        var bruto = 0;
        var total = 0;
        var valor = '';
        if (real > 0) {
            for (i = 1; i <= next_inc; i++) {
                valor = $('#total-' + i).val();
                if (valor) {
                    total = numeral().unformat(valor);
                    bruto += total;
                }
                valor = '';
            }
        }
        $('#Sales_sale_total').val(bruto);
        $('#valorBruto').html('$ ' + numeral(bruto).format('0,0'));
        $('#valorBruto').html('$ ' + numeral(bruto).format('0,0'));
        var tax = $('#taxCustom').val() * bruto;
        $('#valorImp').html('$ ' + numeral(tax).format('0,0'));
        var dis = $('#disCustom').val() * bruto;
        $('#valorDes').html('$ ' + numeral(dis).format('0,0'));
        var granTotal = bruto + tax - dis;
        $('#valorTotal').html('$ ' + numeral(granTotal).format('0,0'));
        $('#Sales_sale_net_worth').val(granTotal);
    }
    function customer() {
        var id = $(".customer").val();
        if (id) {
            $.ajax({
                method: "POST",
                url: "<?php echo $this->createUrl('/requests/clientetax') ?>",
                data: {id: id},
                success: function (result) {
                    var myArr = $.parseJSON(result);
                    $('#taxCustom').val(myArr['tax']);
                    $('#disCustom').val(myArr['des']);
                    if (myArr['mail'] == 1) {
                        $("#send_mail").prop("disabled", false);
                    } else {
                        $("#send_mail").bootstrapToggle('off')
                        $("#send_mail").prop("disabled", true);
                    }
                    bruto();
                }

            })
        } else {
            $('#taxCustom').val(0);
            $('#disCustom').val(0);
            bruto();
        }
    }
    $('#saveComp').click(function () {
        $('#Sales_sale_status').val(1);
        guardar();
    });
    $('#savePen').click(function () {
        $('#Sales_sale_status').val(0);
        guardar();
    });
    function guardar() {
        var next_inc = Number($("#num_registros").val());
        var real = Number($("#num_real").val());
        var error = 0
        for (i = 1; i <= next_inc; i++) {
            var selec = 0;
            selec = Number($('#prod_' + i).val());
            if (selec > 0) {
                var un = $('#cant-' + i).val();
                if (un < 1) {
                    error++;
                    $('#cant-' + i).addClass("error-comp");
                } else
                    $('#cant-' + i).removeClass("error-comp");
                var price = $('#price-' + i).val();
                if (price < 1) {
                    error++;
                    $('#price-' + i).addClass("error-comp");
                } else
                    $('#price' + i).removeClass("error-comp");
            }
        }
        var date = $('#Sales_sale_date').val();
        if (!date) {
            $('#Sales_sale_date').addClass("error-comp");
            error++;
        } else {
            $('#Sales_sale_date').removeClass("error-comp");
        }
        var supp = $('#Sales_customer_nit').val();
        if (!supp) {
            $('#Sales_customer_nit').addClass("error-comp");
            error++;
        } else {
            $('#Sales_customer_nit').removeClass("error-comp");
        }
        if (error > 0 || real < 1) {
            var dato = new Array();
            dato["mensaje"] = "Por favor seleccione por lo menos un producto y valide los campos en rojo.";
            dato["estado"] = 'danger';
            viewAlert(dato);
            $("#general").removeClass('false');
            $('#datos-generales').show(1500);
            $('#movimientos').switchClass("col-md-12 col-lg-12", "col-md-8 col-lg-8", 1000, "easeInOutQuad");
        } else {
            $("#div-errores-store").hide(1000);
            $('#modalComp').modal('hide');
            $('#sales-form').submit();
        }
    }
</script>