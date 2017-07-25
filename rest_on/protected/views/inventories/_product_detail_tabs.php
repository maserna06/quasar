<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#general_view" data-toggle="tab" aria-expanded="true">Vista general</a></li>
    <?php if ($stock): ?>
      <li class=""><a href="#stock_view" data-toggle="tab" aria-expanded="false">Inventario de producto</a></li>
    <?php endif; ?>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="general_view">
      <div class="row">
        <div class="col-md-4 col-sm-12">
          <img class="img-responsive" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?php echo $product['product_image'] ?>" alt="<?php echo $product['product_description']; ?>">
        </div>
        <div class="col-md-8 col-sm-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $product['product_remarks'] ?></h3>
            </div>
            <div class="box-body">
              <div class="text-muted">
                <strong>Categoria</strong>: <?php echo $product['category_description']; ?>
              </div>
              <hr>
              <div class="text-muted">
                <strong>Unidad</strong>: <?php echo $product['unit_name']; ?>
              </div>
              <hr>
              <div class="text-muted">
                <strong>Inventario</strong>: <?php echo $product['stock']; ?>
              </div>
              <hr>
              <div class="text-muted price-modal">
                <strong >Precio</strong>: $ <?php echo number_format($product['product_price'], 0); ?>
              </div>
            </div>
          </div>
        </div> 
      </div> 
    </div>
    <?php if ($stock): ?>
      <div class="tab-pane" id="stock_view">
        <table class="table table-striped table-bordered table-hover table-condensed">
          <?php foreach ($stock as $item) {
            ?>
            <tr>
              <td><?php echo $item['wharehouse_name'] ?></td>
              <td><?php echo $item['inventory_stock'] ?></td>
            </tr>
          <?php }
          ?>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>