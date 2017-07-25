<div class="row">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="row-fluid">
      <?php if($products){?>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th></th>
            <th>Producto</th>
            <th>Categoria</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $index => $product) { ?>
            <tr>
              <td><img width="34" height="34" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?php echo $product['product_image'] ?>" alt="<?php echo $product['product_description']; ?>"></td>
              <td><?php echo $product['product_description'] ?></td>
              <td><?php echo $product['category_description']; ?></td>
              <td><a href="#" data-id="<?php echo $product['product_id'];?>" class="btn btn-primary btn-block open-detail">Detalle</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } ?>
    </div>
  </div>
</div>