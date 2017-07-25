<?php $x = 0; ?>
<ul class="nav nav-tabs nav-stacked">
    <div class="hidden">
        <h4><a href="#">xxx</a>
            <small><i class="fa fa-usd"></i></small>
            <?php
            echo CHtml::link('rtyu', Yii::app()->controller->createUrl("taxes", array('product' => 0)), array(
                'class' => 'btn btn-success pull-right',
                'data-toggle' => 'tooltip',
                'data-placement' => 'right',
                'data-original-title' => ' tax',
                'ajax' => array(
                    'type' => 'get',
                    'url' => 'js:$(this).attr("href")',
                    'beforeSend' => 'function(){ $("#div-content").addClass("loadingwait"); }',
                    'complete' => 'function(){ $("#div-content").removeClass("loadingwait"); }',
                    'success' => 'function(data) { $("#datos-taxes").html(data); }'
                ),
            ));
            ?>
        </h4>
    </div>
    <?php
    $x = 0;
    foreach ($bodegas as $tax) {
        if ($x % 3 == 0) {
            ?>
            <li>
                <div class="row">
                <?php } ?>
                <div class="col-sm-4">
                    <h4><a href="#"><?= $tax['name'] ?></a>
                        <small><i class="fa fa-map-pin"></i></small>
                            <?php
                            echo CHtml::link($tax['estado'], Yii::app()->controller->createUrl("bodegas", array('user' => $model->user_id, 'bod' => $tax['id'], 'accion' => ($tax['estado'] == 'On') ? 0 : 1)), array(
                                'class' => ($tax['estado'] == 'On') ? 'btn btn-success pull-right' : 'btn btn-danger pull-right',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'right',
                                'data-original-title' => $tax['name'],
                                'ajax' => array(
                                    'type' => 'get',
                                    'url' => 'js:$(this).attr("href")',
                                    'beforeSend' => 'function(){ $("#div-content").addClass("loadingwait"); }',
                                    'complete' => 'function(){ $("#div-content").removeClass("loadingwait"); }',
                                    'success' => 'function(data) { $("#datos-taxes").html(data); }'
                                ),
                            ));
                            ?>
                    </h4>
                </div>

                <?php if ($x % 3 == 2 || $x == count($bodegas) - 1) { ?>
                </div>
                <hr>
            </li>
        <?php } ?>
        <?php
        $x++;
    }
    ?>

</ul>

