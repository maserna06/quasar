<?php

use App\User\User as U;

$user = U::getInstance();
$visible = $user->isSupervisor;
$isAdmin = $user->isAdmin;

$this->menu = array(
    array('label' => 'Ver Ordenes', 'url' => array('indexes')),
    array('label' => 'Crear Orden', 'url' => array('index'), 'visible' => $visible),
    array('label' => ($isAdmin ? 'Administrar' : 'Ver') . ' Ordenes', 'url' => array('indexes')),
);
$empresa = Yii::app()->getSession()->get('empresa');
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'order-form',
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
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <!--<div class="box-header">
      <h3 class="box-title">Orden <small>Actualizar Orden</small></h3>
    </div>-->
                <div class="box-body">
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
                                    <div class="alert alert-danger" id="div-errores" style="display: none;">Por favor valide qie selecciono por lo menos un producto y diligencie todos los datos en rojo.</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <div style="max-height: 500px; overflow-y: scroll;"  >
                                                    <table class="table table-bordered" >
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
                                                        <tbody id="tablaproductos">

                                                        </tbody>
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
                                                            <?php echo $form->hiddenField($model, 'order_total', array('class' => 'form-control')); ?>
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
                                                            <?php echo $form->hiddenField($model, 'order_net_worth', array('class' => 'form-control')); ?>
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
                                            echo CHtml::hiddenField("detail", isset($datos['products']) ? $datos['products'] : 0);
                                            echo CHtml::hiddenField("status", ($model->order_status) ? $model->order_status : 0);
                                            ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-9">                                
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-at"></i>
                                                </div><input class="form-control" value="Orden por email" type="text" readonly="readonly">      
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button name="button" type="button" class="btn btn-block btn-default" <?= ($empresa == 0) ? 'disabled' : '' ?>>Enviar</button>
                                        </div>
                                    </div>
                                    <br>                        
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><?php echo $form->labelEx($model, 'order_remarks'); ?></label>                                
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-sticky-note-o"></i>
                                                </div>
                                                <?php echo $form->textArea($model, 'order_remarks', array('size' => 60, 'maxlength' => 500, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <br>                        
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">
                                            <button name="button" id="savePen" type="button" class="btn btn-block btn-default btn-lg " <?= ($empresa == 0) ? 'disabled' : '' ?>>Pendiente</button>
                                        </div>
                                        <div class="col-md-3">

                                            <?php echo CHtml::button('Aprobada', array('id' => 'saveComp', 'class' => 'btn btn-block btn-success btn-lg', 'disabled' => ($empresa == 0) ? 'disabled' : '')); ?>
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
                                            <label><?php echo $form->labelEx($model, 'order_date'); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <?php
                                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                    'model' => $model,
                                                    'attribute' => 'order_date',
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
                                                #sub
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
                                                <?php echo $form->hiddenField($model, 'order_status', array('class' => 'form-control', 'value' => '1')); ?>
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
                                                echo $form->dropDownList($model, 'supplier_nit', SuppliersExtend::supplierCompany(), array('class' => 'form-control', 'prompt' => '--Seleccione--'));
                                                ?> 
                                            </div>
                                        </div>                          
                                    </div>
                                    <br>
                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <button name="button" type="button" class="btn btn-block btn-info" <?= ($empresa == 0) ? 'disabled' : '' ?>>Buscar Proveedores</button>
                                        </div>                            
                                    </div>
                                    <br>-->
                                    <div class="row">                           
                                        <div class="col-md-12">
                                            <label><?php echo $form->labelEx($model, 'accounts_id'); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-money"></i>
                                                </div>
                                                <?php
                                                $account = CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name');
                                                echo $form->dropDownList($model, 'accounts_id', $account, array('class' => 'form-control', 'prompt' => '--Seleccione--', 'options' => array($datos['orderConfig']->accounts_id => array('selected' => true))));
                                                ?>  
                                            </div>
                                        </div>                          
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
<?php $this->renderPartial('../_modal'); ?> 

<?php if (Yii::app()->getSession()->get('empresa') == 0) { ?>
                    <!--<script src="<?php #echo Yii::app()->theme->baseUrl;      ?>/bootstrap/js/bootstrap.min.js"></script>-->
    <script>
        jQuery(function ($) {
            $("#myModal").modal('show');
            $(".modal-title").html("Información");
            $("#bodyArchivos").html("<p style='padding-left:15px;'>No tienen ninguna Empresa asociada</p>");
            $(".modal-footer").html("<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>");
            $('#newProd').bind('click', false);
        });
    </script>
<?php } ?>

<!--<link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->

<script>
    function calcular(dato) {
        var idProd = dato.id;
        idProd = idProd.split("-");
        var cant = $('#cant-' + idProd[1]).val();
        var valor = $('#price-' + idProd[1]).val();
        var total = numeral(cant * valor).format('0,0');
        $('#total-' + idProd[1]).val(total);
        bruto();
        return false;
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
        $('#Order_order_total').val(bruto);
        $('#valorBruto').html('$ ' + numeral(bruto).format('0,0'));
        $('#valorBruto').html('$ ' + numeral(bruto).format('0,0'));
        var tax = $('#taxSup').val() * bruto;
        $('#valorImp').html('$ ' + numeral(tax).format('0,0'));
        var dis = $('#disSup').val() * bruto;
        $('#valorDes').html('$ ' + numeral(dis).format('0,0'));
        var granTotal = bruto + tax - dis;
        $('#valorTotal').html('$ ' + numeral(granTotal).format('0,0'));
        $('#Order_order_net_worth').val(granTotal);
        return false;

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
                repetido = 1;
            }
        }
        if (repetido == 0) {
            next_inc = next_inc + 1;
            real = real + 1;
            d.getElementById('num_registros').value = next_inc;
            var tr = d.createElement('tr');
            tr.id = 'trprod' + next_inc;
            container.appendChild(tr);
            var iden = 'trprod' + next_inc;
            $('#' + iden).load("<?= Yii::app()->baseUrl ?>/products/productView?id_prod=" + idprod + '&cantidad=' + next_inc, function (response, status, xhr) {
                if (response == '') {
                    container.removeChild(tr);
                    next_inc = next_inc - 1;
                    real = real - 1;
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
        function vaciar() {
            $('#findProduct').val('');
        }
        $('#findProduct').on('focus', vaciar);
        $('#newProd').on('click', newProd);
        var detail = $('#detail').val();
        var status = $('#status').val();

        if (status == 2) {
            $('#order-form').find('input, textarea, button, select, a').attr('disabled', 'disabled');
            $('#order-form').find('a').removeAttr("onclick");
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
        if (detail != 0) {
            var myArr = $.parseJSON(detail);
            detalle(myArr);
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
                    $("#num_registros").val(next_inc);
                    $("#num_real").val(real);
                    $('#order-form').find('input, textarea, button, select').attr('disabled', 'disabled');
                    $('#order-form').find('a').removeAttr("onclick");
                    bruto();
                });
            }
            var id = $("#Order_supplier_nit").val();
            suplier(id);
        }
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
                    vaciar();
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

        })
        function newProd(e) {
            /*e.preventDefault();
             $("#bodyArchivos").html('');
             $.ajax({
             url: "<?php #echo $this->createUrl('/order/fastproduct')      ?>",
             success: function(result) {
             $("#bodyArchivos").html(result);
             $("#myModal").modal({keyboard: false});
             $(".modal-dialog").width("60%");
             $(".modal-title").html("Crear Producto");
             $(".modal-footer").html("");
             }
             });*/

            return false;

        }


        $("#Order_supplier_nit").change(function () {
            var id = $("#Order_supplier_nit").val();
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


        $('#saveComp').click(function () {
            $('#Order_order_status').val(1);
            guardar();
        });
        $('#savePen').click(function () {
            $('#Order_order_status').val(0);
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
            var date = $('#Order_order_date').val();
            if (!date) {
                $('#Order_order_date').addClass("error-comp");
                error++;
            } else {
                $('#Order_order_date').removeClass("error-comp");
            }
            var supp = $('#Order_supplier_nit').val();
            if (!supp) {
                $('#Order_supplier_nit').addClass("error-comp");
                error++;
            } else {
                $('#Order_supplier_nit').removeClass("error-comp");
            }
            if (error > 0 || real < 1) {
                $("#div-errores").show(1000);
            } else {
                $("#div-errores").hide(1000);
                $('#order-form').submit();
            }
        }

    });

</script>

<script>
    $('#order-form').find('input, textarea, button, select').attr('disabled', 'disabled');
    $('#order-form').find('a').removeAttr("onclick");
</script>