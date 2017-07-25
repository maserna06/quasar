<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div data-force="30" class="layer block" style="left: 14.5%; top: 0; width: 37%">
    <ul id="foo" class="block__list block__list_words">
    </ul>
</div>

<div data-force="18" class="layer block" style="left: 58%; top: 143px; width: 40%;">
    <ul id="bar" class="block__list block__list_tags">

    </ul>
</div>
<div id="multi">
    <div class="col-md-7 category-modal">
        <div class="panel-group" id="accordion">
            <?php
            $i = 1;
            foreach ($model as $mod) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
                                <i class="fa fa-ellipsis-v"></i>

                                <?= $mod['datos']['name'] ?>    

                                <b class="pull-right">></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="tile__list" id="padre-<?= $i ?>">
                                <?php foreach ($mod['prod'] as $prod) { ?>
                                <div id="div-prod-<?= $prod['product_id'] ?>" class="div-prod-<?= $prod['product_id'].'-'.$i ?>">
                                        <input type="hidden" value="<?= $prod['product_id'] ?>" id="product" name="producto[]"/>
                                        <image  height="70" width="70" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?= $prod['product_image'] ?>"/>
                                        <?= $prod['product_description'] ?> 
                                        <i class="pull-right" style="margin-top: 2%; text-align: center; width: 120px;">$ <?= number_format($prod['product_price']) ?>
                                            <br>
                                            <label style="font-size: 12px">
                                            <?=$prod['unit_name']?> 
                                            </label>
                                            <br>
                                            <a class="add-true" id="a-<?= $prod['product_id'] ?>" onclick="pasar(<?= $prod['product_id'] ?>, this)"><b>Seleccionar</b></a>
                                            <?php echo CHtml::hiddenField("padre", $i); ?>
                                        </i>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
    </div>
    <div class="col-md-5 category-modal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    PRODUCTOS SELECCIONADOS
                </h4>
            </div>
            <div class="panel-body">
                <div id="lista_final" class="tile__list final">

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .category-modal {
        height:500px;
        overflow:auto;
    }
</style>

<script>
//    function pasar(id) {
//        var accion = $('#a-' + id).attr('class');
//        if (accion == 'add-true') {
//            $('#div-prod-' + id).appendTo('#lista_final');
//            $('#a-' + id).html('<b style="color:red">Eliminar</b>');
//            $('#a-' + id).removeClass('add-true');
//            $('#a-' + id).addClass('add-false');
//        }
//        if (accion == 'add-false') {
//            var padre = $('a#a-' + id).siblings('input#padre').val();
//            $('#div-prod-' + id).appendTo('#padre-' + padre);
//            $('#a-' + id).html('<b >Seleccionar</b>');
//            $('#a-' + id).removeClass('add-false');
//            $('#a-' + id).addClass('add-true');
//        }
//    }
//    function jsCalculaTotal() {
//        $(".final input").each(function () {
//            if ($(this).attr('id') != 'padre') {
//                var idProd = $(this).val();
//                addProd(idProd);
//            }
//        })
//        $("#myModal").modal('hide');
//    }
</script>
<!--
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/Sortable-master/Sortable.js"></script>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/Sortable-master/st/app.js"></script>-->
