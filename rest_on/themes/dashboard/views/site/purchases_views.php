<?php
    $labesls=Purchases::model()->attributeLabels();
    $order = Order::model()->findByPk($data->order_id);
?>
<div class="col-sm-3">
    <div class="purchase">
    <div class="market">
        <div class="purchase-info">
            <p class="purchase-title">
                Compra #  <?= $data->purchase_consecut ?> 
                <?php if ($data->purchase_status == 0): ?>
                    <i class="fa fa-circle  text-warning"></i>
                <?php elseif ($data->purchase_status == 1): ?>
                    <i class="fa fa-circle text-success"></i>
                <?php else: ?>
                    <i class="fa fa-circle text-danger"></i>
                <?php endif; ?>
            </p>
            <p><span class="purchase-label"><?= $labesls['purchase_date'] ?></span>: <?= $data->purchase_date ?></p>
            <p>
               
            </p>
             <p><span class="purchase-label"><?=$labesls['order_id']?></span>: <?=$order->order_consecut?></p>
        </div>
        <div>
            <div class="purchase-remarks">    
                <p><?= $data->purchase_remarks ?></p>
            </div>
            <p align="center">
                <a href="javaScript:purchaseDetails(<?= $data->purchase_id ?>)" class="btn btn-primary btn-block">Detalle</a>
            </p>
        </div>
    </div>
    </div>
</div>