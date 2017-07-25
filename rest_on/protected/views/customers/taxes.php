<?php $x = 0; ?>
<ul class="nav nav-tabs nav-stacked">
<?php
    foreach ($taxes as $tax) {       
?>
        <li>
            <div class="row">
                <div class="col-sm-12">
                    <h4><a href="#"><?= $tax['name'] ?></a>
                        <small><i class="fa fa-usd"></i></small>
                            <?php
                            echo CHtml::link($tax['estado'], Yii::app()->controller->createUrl("taxes", array('customer' => $model->customer_nit, 'tax' => $tax['id'], 'accion' => ($tax['estado'] == 'On') ? 0 : 1)), array(
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
            </div>
            <hr>
        </li>
<?php } ?>
</ul>

