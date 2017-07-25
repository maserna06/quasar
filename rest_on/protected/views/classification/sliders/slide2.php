<fieldset id="slide-2">
    <div class="row">
        <div class="col-sm-12 content-products">
          <div class="row-fluid">
            <div class style= "overflow-y:scroll;height:350px">
              <?php foreach ($products as $product): ?>
               
                <div class="col-xs-12 col-sm-6 col-md-3 parent-display">
                    
                  <div class="display-product default-3d ">
                    <label for="product-<?php echo $product['product_id'] ?>">
                      <img width="50" height="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?= $product['product_image'] ?>" alt="<?php echo $product['product_description'] ?>">
                      <div class="small">
                        <h3>
                          <?php echo $product['product_description'] ?>
                          <span>$<?php echo number_format($product['product_price'], 0) ?></span>
                        </h3>
                      </div>
                      <div class="hidden toogle-check btn btn-danger">Off</div>
                      <div class="hidden">
                        <input <?php
                        if (isset($product['product_related']) && $product['product_related'] == $product['product_id']) {
                          echo ' checked ';
                        }
                        ?> name="product[<?php echo $product['product_id'] ?>]" id="product-<?php echo $product['product_id'] ?>" value="<?php echo $product['product_id'] ?>" type="checkbox" />
                      </div>
                    </label>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>        
    </div>
    <input type="button" name="previous" class="previous col-sm-6 btn btn-block btn-danger btn-lg" value="Anterior" />
    <input type="button" id="next-2" name="next" class="next col-sm-6 btn btn-block btn-success btn-lg" value="Siguiente" />
</fieldset>
