<div class="row">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="row-fluid">
      <?php 
      if($products){
      foreach ($products as $index => $product) { ?>
        <div class="col-sm-4 col-md-2">
          <div class="thumbnail">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?php echo $product['product_image'] ?>" alt="<?php echo $product['product_description']; ?>">
            <!--<img src="http://placehold.it/320x200" alt="ALT NAME">-->
            <div class="caption">
              <h3><?php echo $product['product_description'] ?></h3>
              <div class="category"><?php echo $product['category_description']; ?></div>
              <p align="center"><a data-id="<?php echo $product['product_id'];?>" href="#" class="btn btn-primary btn-block open-detail">Detalle</a></p>
            </div>
          </div>
        </div>
      <?php }
      }?>
    </div>
  </div>
</div>