<?php
/* @var $this PurchasesController */
/* @var $model Purchases */

use App\User\User as U;

$user = U::getInstance();
$visible = $user->isSupervisor;
$isAdmin = $user->isAdmin;

$this->menu = array(
    array('label' => 'Ver Compras', 'url' => array('indexes')),
    array('label' => 'Crear Compra', 'url' => array('index'), 'visible' => $visible),
    array('label' => ($isAdmin ? 'Administrar' : 'Ver') . ' Compras', 'url' => array('indexes')),
);
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!--<div class="box-header">
      <h3 class="box-title">Compra <small>Crear Compra</small></h3>
    </div>-->
                <div class="box-body">
                    <?php
                    $empresa = Yii::app()->getSession()->get('empresa');
                    /* @var $this PurchasesController */
                    /* @var $model Purchases */
                    /* @var $form CActiveForm */
                    ?>

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'purchases-form',
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
                                                    <i class="fa fa-cart-plus" title="Ver Productos" <?= ($empresa == 0) ? 'disabled' : '' ?>></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-1 col-md-1 col-lg-1">
                                            <div class="row">    
                                                <div class="col-md-12">
                                                    <i class="fa fa-refresh" title="Ultimo Movimiento"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-1 col-md-1 col-lg-1">
                                            <div class="row">    
                                                <div class="col-md-12">
                                                    <i class="fa fa-download" title="Descarga de Documentos"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-1 col-md-1 col-lg-1">
                                            <div class="row">    
                                                <div class="col-md-12">
                                                    <i class="fa fa-cubes" title="Crear Producto"></i>
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
                                    <div class="alert alert-danger" id="div-errores" style="display: none;">Por favor valide que selecciono por lo menos un producto y diligencie todos los datos en rojo.</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <div style="max-height: 500px; overflow-y: scroll;">
                                                    <table class="table table-bordered" id="tablaproductos">
                                                        <thead>
                                                            <tr>
                                                                <td class="text-center"><strong>Producto</strong></td>
                                                                <td class="text-center"><strong>Bodega</strong></td>
                                                                <td class="text-center"><strong>Cantidad</strong></td>
                                                                <td class="text-center"><strong>Unidad</strong></td>
                                                                <td class="text-center"><strong>Precio</strong></td>
                                                                <td class="text-center"><strong>Total</strong></td>
                                                                <td class="text-center"></strong></td>
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
                                                            <?php echo $form->hiddenField($model, 'purchase_total', array('class' => 'form-control')); ?>
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
                                                            <?php echo $form->hiddenField($model, 'purchase_net_worth', array('class' => 'form-control')); ?>
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
                                            echo CHtml::hiddenField("taxSup", 0);
                                            echo CHtml::hiddenField("disSup", 0);
                                            echo CHtml::hiddenField("detail", 0);
                                            echo CHtml::hiddenField("detailPurchase", ($datos['products']) ? $datos['products'] : 0);
                                            ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-9">                                
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-at"></i>
                                                </div><input class="form-control" value="Factura por email" type="text" readonly="readonly">      
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button name="button" type="button" class="btn btn-block btn-default" <?= ($empresa == 0) ? 'disabled' : '' ?>>Enviar</button>
                                        </div>
                                    </div>
                                    <?php if ($datos['facConfig']->purchase_payment == 1) { ?>
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

                                                <button name="button" type="button" class="btn btn-block btn-default">Detallar</button>

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><?php echo $form->labelEx($model, 'purchase_remarks'); ?></label>                                
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-sticky-note-o"></i>
                                                </div>
                                                <?php echo $form->textArea($model, 'purchase_remarks', array('size' => 60, 'maxlength' => 500, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <br>                        
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">
                                            <button name="button" id="savePen" type="button" class="btn btn-block btn-default btn-lg" <?= ($empresa == 0) ? 'disabled' : '' ?>>Pendiente</button>
                                        </div>
                                        <div class="col-md-3">
                                            <?php echo CHtml::button('Pagada', array('id' => 'saveComp', 'class' => 'btn btn-block btn-success btn-lg', 'disabled' => ($empresa == 0) ? 'disabled' : '')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 col-lg-4 " style="display: none;" id="datos-generales">
                            <div class="panel panel-default height">
                                <div class="panel-heading">Datos Generales</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><?php echo $form->labelEx($model, 'purchase_date'); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <?php
                                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                    'model' => $model,
                                                    'attribute' => 'purchase_date',
                                                    'language' => 'es',
                                                    'options' => array(
                                                        'dateFormat' => 'yy-mm-dd',
                                                    ),
                                                    'htmlOptions' => array(
                                                        'readonly' => 'readonly',
                                                        'class' => 'form-control',
                                                        'size' => '10', // textField size
                                                        'maxlength' => '10', // textField maxlength
                                                        'value' => date('Y-m-d'),
                                                    ),
                                                ));
                                                ?>
                                            </div>
                                        </div>                            
                                    </div>
                                    <br>
                                    <div class="row">                           
                                        <div class="col-md-12">
                                            <label><?php echo $form->labelEx($model, 'order_id'); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clone"></i>
                                                </div>
                                                <?php
                                                if ($model->order_id > 0) {
                                                    echo $form->hiddenField($model, 'order_id', array('readonly' => 'readonly', 'class' => 'form-control'));
                                                    echo CHtml::textField('', $model->order->order_consecut, array('readonly' => 'readonly', 'class' => 'form-control'));
                                                } else {
                                                    $order = CHtml::listData(Order::model()->findAll('order_status = 1 and company_id = ' . Yii::app()->getSession()->get('empresa')), 'order_id', 'order_consecut');
                                                    echo $form->dropDownList($model, 'order_id', $order, array('class' => 'form-control', 'prompt' => '--Seleccione--', 'options' => array($model->order_id => array('selected' => true))));
                                                }
                                                ?> 
                                            </div>
                                        </div>                          
                                    </div>
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
                                                <?php echo $form->hiddenField($model, 'purchase_status', array('class' => 'form-control', 'value' => '1')); ?>
                                            </div>
                                        </div>                            
                                    </div>
                                    <br>
                                    <div class="row">                           
                                        <div class="col-md-12">
                                            <label><?php echo $form->labelEx($model, 'supplier_nit'); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-child"></i>
                                                </div>
                                                <?php
                                                //$supplier = CHtml::listData(Suppliers::model()->findAll('supplier_status = 1'), 'supplier_nit', 'supplier_name');
                                                echo $form->dropDownList($model, 'supplier_nit', SuppliersExtend::supplierCompany(), array('class' => 'form-control', 'prompt' => '--Seleccione--'));
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
                                                echo $form->dropDownList($model, 'accounts_id', $account, array('class' => 'form-control', 'prompt' => '--Seleccione--', 'options' => array($datos['facConfig']->accounts_id => array('selected' => true))));
                                                ?>  
                                            </div>
                                        </div>                          
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>

                    <!-- Modal para Crear Nuevo producto -->
                    <?php $this->renderPartial('../_modal'); ?> 

                    <?php if (Yii::app()->getSession()->get('empresa') == 0) { ?>
                        <script>
                            $("#myModal").modal('show');
                            $(".modal-title").html("Información");
                            $("#bodyArchivos").html("<p style='padding-left:15px;'>No tienen ninguna Empresa asociada</p>")
                            $(".modal-footer").html("<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>")
                            $('#newProd').bind('click', false);
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
                            $('#Purchases_purchase_total').val(bruto);
                            $('#valorBruto').html('$ ' + numeral(bruto).format('0,0'));
                            var tax = $('#taxSup').val() * bruto;
                            $('#valorImp').html('$ ' + numeral(tax).format('0,0'));
                            var dis = $('#disSup').val() * bruto;
                            $('#valorDes').html('$ ' + numeral(dis).format('0,0'));
                            var granTotal = bruto + tax - dis;
                            $('#valorTotal').html('$ ' + numeral(granTotal).format('0,0'));
                            $('#Purchases_purchase_net_worth').val(granTotal);


                        }

                        function BorrarCampo(iteracion) {
                            /*var container = document.getElementById('tablaproductos');
                             var tr = document.getElementById("trprod" + iteracion);
                             container.removeChild(tr);
                             var next_inc = container.getElementsByTagName('tr').length - 1;
                             $("#num_real").val(next_inc);
                             bruto();*/
                            return false;
                        }

                        function addProd(idprod) {
                            var d = document;
                            var container = d.getElementById('tablaproductos');
                            var next_inc = Number($("#num_registros").val());
                            var real = Number($("#num_real").val());
                            var selec = 0;
                            var repetido = 0;
                            for (i = 1; i <= next_inc; i++) {
                                selec = $('#prod_' + i).val();
                                if (selec == idprod) {
                                    repetido = 1
                                }
                            }
                            if (repetido == 0) {
                                next_inc = next_inc + 1;
                                real = real + 1
                                d.getElementById('num_registros').value = next_inc
                                var tr = d.createElement('tr');
                                tr.id = 'trprod' + next_inc;
                                container.appendChild(tr);
                                var iden = 'trprod' + next_inc;
                                $('#' + iden).load("<?= Yii::app()->baseUrl ?>/products/productView?id_prod=" + idprod + '&cantidad=' + next_inc, function (response, status, xhr) {
                                    if (response == '') {
                                        container.removeChild(tr);
                                        next_inc = next_inc - 1;
                                        real = real - 1;
                                        vaciar();
                                    }
                                    $('#' + iden).find('input.calcular').on('keyup mouseup', function () {
                                        calcular(this);
                                    });
                                    $("#num_registros").val(next_inc);
                                    $("#num_real").val(real);
                                    bruto();
                                });
                            }
                        }

                        jQuery(function ($) {
                            $('#newProd').on('click', newProd);
                            var detail = $('#detailPurchase').val();
                            if (detail != 0) {
                                var myArr = $.parseJSON(detail);
                                detallePurchase(myArr);
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

                            function detallePurchase(myArr) {
                                var d = document;
                                var container = d.getElementById('tablaproductos');
                                var next_inc = Number($("#num_registros").val());
                                var real = Number($("#num_real").val());
                                for (i = 0; i < myArr.length; i++) {
                                    next_inc = next_inc + 1;
                                    real = real + 1
                                    var tr = d.createElement('tr');
                                    tr.id = 'trprod' + next_inc;
                                    container.appendChild(tr);
                                    var iden = 'trprod' + next_inc;
                                    $('#' + iden).load("<?= Yii::app()->baseUrl ?>/purchases/detailView?id_detail=" + myArr[i] + '&cantidad=' + next_inc, function (response, status, xhr) {
                                        if (response == '') {
                                            container.removeChild(tr);
                                            next_inc = next_inc - 1;
                                            real = real - 1;
                                        }
                                        $("#num_registros").val(next_inc);
                                        $("#num_real").val(real);
                                        $('#purchases-form').find('input, textarea, button, select').attr('disabled', 'disabled');
                                        $('#purchases-form').find('a').removeAttr("onclick");
                                        bruto();
                                    });
                                }
                                var id = $("#Purchases_supplier_nit").val();
                                suplier(id);
                            }


                            function detalle(myArr) {
                                var d = document;
                                var container = d.getElementById('tablaproductos');
                                var next_inc = Number($("#num_registros").val());
                                var real = Number($("#num_real").val());
                                for (i = 0; i < myArr.length; i++) {
                                    next_inc = next_inc + 1;
                                    real = real + 1
                                    var tr = d.createElement('tr');
                                    tr.id = 'trprod' + next_inc;
                                    container.appendChild(tr);
                                    var iden = 'trprod' + next_inc;
                                    $('#' + iden).load("<?= Yii::app()->baseUrl ?>/order/detailView?id_detail=" + myArr[i] + '&cantidad=' + next_inc, function (response, status, xhr) {
                                        if (response == '') {
                                            container.removeChild(tr);
                                            next_inc = next_inc - 1;
                                            real = real - 1;
                                        }
                                        $('#purchases-form').find('input, textarea, button, select').attr('disabled', 'disabled');
                                        $('#purchases-form').find('a').removeAttr("onclick");
                                        bruto();
                                    });
                                    $("#num_registros").val(next_inc);
                                    $("#num_real").val(real);
                                }
                                var id = $("#Purchases_supplier_nit").val();
                                suplier(id);
                            }
                            $('#saveComp').click(function () {
                                $('#Purchases_purchase_status').val(1);
                                guardar();
                            });
                            $('#savePen').click(function () {
                                $('#Purchases_purchase_status').val(0);
                                guardar();
                            });
                            (function ($) {
                                var $project = $('#findProduct');
                                var projects = function (request, response) {
                                    $.ajax({
                                        url: "<?php echo $this->createUrl('/products/autoorder') ?>",
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
                                    $li.append('<a >');
                                    $li.find('a').append($img).append(item.label).append($b);
                                    $li.find('b').append(item.price + "<br>" + "unidades");
                                    return $li.appendTo(ul);
                                };
                            })(jQuery);


                            $('#viewProducts').click(function () {
                                $("#bodyArchivos").html('');
                                $.ajax({
                                    url: "<?php echo $this->createUrl('/order/viewproducts') ?>",
                                    success: function (result) {
                                        $("#bodyArchivos").html(result);
                                        $("#myModal").modal({keyboard: false});
                                        $(".modal-dialog").width("80%");
                                        $(".modal-title").html("Ver Productos");
                                        $(".modal-footer").html("<div><div class='col-md-6'><div class='form-group'><input class='btn btn-block btn-success' onclick='jsCalculaTotal()' name='yt1' type='button' value='Guardar' /></div></div><div class='col-md-6'><div class='form-group'><input class='btn btn-block btn-danger' data-dismiss='modal' type='button' name='yt1' value='Cancelar' /></div></div></div>");
                                    }
                                });

                            });
                            function newProd() {
                                $("#bodyArchivos").html('');
                                $.ajax({
                                    url: "<?php echo $this->createUrl('/order/fastproduct') ?>",
                                    success: function (result) {
                                        $("#bodyArchivos").html(result);
                                    }
                                });
                                $("#myModal").modal({keyboard: false});
                                $(".modal-dialog").width("60%");
                                $(".modal-title").html("Crear Producto");
                                $(".modal-footer").html("");
                            }

                            function vaciar()
                            {
                                $('#findProduct').val('');
                            }


                            $("#Purchases_supplier_nit").change(function () {
                                var id = $("#Purchases_supplier_nit").val();
                                suplier(id);

                            });

                            function suplier(id) {
                                if (id) {
                                    $.ajax({
                                        method: "POST",
                                        url: "<?php echo $this->createUrl('/order/proveedortax') ?>",
                                        data: {id: id},
                                        success: function (result) {
                                            var myArr = $.parseJSON(result);
                                            $('#taxSup').val(myArr['tax']);
                                            $('#disSup').val(myArr['des']);
                                            bruto();
                                        }

                                    })
                                } else {
                                    $('#taxSup').val(0);
                                    $('#disSup').val(0);
                                    bruto();
                                }
                            }

                            $("#Purchases_order_id").change(function () {
                                limpiar();
                                var id = $("#Purchases_order_id").val();
                                if (id > 0) {
                                    $.ajax({
                                        method: "POST",
                                        url: "<?php echo $this->createUrl('/order/order') ?>",
                                        data: {id: id},
                                        success: function (result) {
                                            var datos = $.parseJSON(result);
                                            $('#Purchases_accounts_id').val(datos['cuenta']);
                                            $('#Purchases_supplier_nit').val(datos['proveedor']);
                                            $('#Purchases_purchase_remarks').val(datos['obs']);
                                            suplier(datos['proveedor']);
                                        }

                                    })
                                    $.ajax({
                                        method: "POST",
                                        url: "<?php echo $this->createUrl('/order/orderdetail') ?>",
                                        data: {id: id},
                                        success: function (result) {
                                            var myArr = $.parseJSON(result);
                                            if (myArr.length > 0) {
                                                detalle(myArr);
                                            }
                                        }

                                    })

                                }

                            });
                            function limpiar() {
                                $('#tablaproductos').html('<thead><tr><td class="text-center"><strong>Producto</strong></td><td class="text-center"><strong>Bodega</strong></td><td class="text-center"><strong>Cantidad</strong></td><td class="text-center"><strong>Unidad</strong></td><td class="text-center"><strong>Precio</strong></td><td class="text-center"><strong>Total</strong></td><td class="text-center"></td></tr></thead>');
                                $("#num_registros").val(0);
                                $("#num_real").val(0);
                                $("#Purchases_purchase_remarks").val('');
                                $("#Purchases_supplier_nit").val('');
                                $("#taxSup").val(0);
                                $("#disSup").val(0);
                                $('#valorBruto').html('$ 0');
                                $('#valorImp').html('$ 0');
                                $('#valorDes').html('$ 0');
                                $('#valorTotal').html('$ 0');


                            }
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
                                var date = $('#Purchases_purchase_date').val();
                                if (!date) {
                                    $('#Purchases_purchase_date').addClass("error-comp");
                                    error++;
                                } else {
                                    $('#Purchases_purchase_date').removeClass("error-comp");
                                }
                                var supp = $('#Purchases_supplier_nit').val();
                                if (!supp) {
                                    $('#Purchases_supplier_nit').addClass("error-comp");
                                    error++;
                                } else {
                                    $('#Purchases_supplier_nit').removeClass("error-comp");
                                }
                                if (error > 0 || real < 1) {
                                    $("#div-errores").show(1000);
                                } else {
                                    $("#div-errores").hide(1000);
                                    $('#purchases-form').submit();
                                }
                            }

                        });
                    </script> 

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>

<script>
    $('#purchases-form').find('input, textarea, button, select').attr('disabled', 'disabled');
    $('#purchases-form').find('a').removeAttr("onclick");
</script>