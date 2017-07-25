<fieldset id="slide-3">
    <div class="row">
        <div class="col-sm-12 content-products">
          <div class="row-fluid">
            <div class style= "overflow-y:scroll;height:350px">
              <?php foreach ($wharehouses as $wharehouse): ?>
                <div class="col-xs-12 col-sm-6 col-md-3 parent-display">
                  <div class="display-product default-3d ">
                    <label for="wharehouse-<?php echo $wharehouse['wharehouse_id'] ?>">
                      <div class="small">
                        <h3>
                          <?php echo $wharehouse['wharehouse_name'] ?>
                          <span><?php echo ($wharehouse['company_id']) ?></span>
                        </h3>
                      </div>
                      <div class="hidden toogle-check btn btn-danger">Off</div>
                      <div class="hidden">
                        <input <?php
                        if (isset($wharehouse['wharehouse_related']) && $wharehouse['wharehouse_related'] == $wharehouse['wharehouse_id']) {
                          echo ' checked ';
                        }
                        ?> name="wharehouse[<?php echo $wharehouse['wharehouse_id'] ?>]" id="wharehouse-<?php echo $wharehouse['wharehouse_id'] ?>" value="<?php echo $wharehouse['wharehouse_id'] ?>" type="checkbox" />
                      </div>
                    </label>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>        
    </div>
    <input type="button" name="previous" class="previous btn btn-block btn-danger btn-lg" value="Anterior" />
    <?php echo CHtml::button($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class' => 'btn btn-block btn-success btn-lg', 'onclick' => 'send();')); ?>
</fieldset>

