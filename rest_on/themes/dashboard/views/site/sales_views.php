<?php
    $labesls=Sales::model()->attributeLabels();
    $request = Requests::model()->findByPk($data->request_id);
?>
<div class="col-sm-3">
    <div class="purchase">
    <div class="market">
        <div class="purchase-info">
            <p class="purchase-title">
               Factura de Venta #  <?= $data->sale_consecut ?> 
                <?php if ($data->sale_status == 0): ?>
                    <i class="fa fa-circle  text-warning"></i>
                <?php elseif ($data->sale_status == 1): ?>
                    <i class="fa fa-circle text-success"></i>
                <?php else: ?>
                    <i class="fa fa-circle text-danger"></i>
                <?php endif; ?>
            </p>
            <p><span class="purchase-label"><?= $labesls['sale_date'] ?></span>: <?= $data->sale_date ?></p>
            <p>
               
            </p>
            <p><span class="purchase-label"><?=$labesls['request_id']?></span>: <?=$request->request_consecut?></p>
        </div>
        <div>
            <div class="purchase-remarks">    
                <p><?= $data->sale_remarks ?></p>
            </div>
            <p align="center">
                <a href="javaScript:saleDetails(<?= $data->sale_id ?>)" class="btn btn-success btn-block btn-success">Detalle</a>
            </p>
        </div>
    </div>
    </div>
</div>