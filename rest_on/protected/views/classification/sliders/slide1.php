<fieldset id="slide-1">
    <div class="row">
        <div class="col-md-12">
          <div class="form-group col-sm-12">
            <label><?php echo $form->labelEx($model, 'classification_name'); ?></label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-bookmark"></i>
              </div><?php echo $form->textField($model, 'classification_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
            </div><!-- /.input group -->
            <br><?php echo $form->error($model, 'classification_name', array('class' => 'alert alert-danger')); ?>
          </div>
          <div class="form-group col-sm-12">
            <label><?php echo $form->labelEx($model, 'classification_description'); ?></label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-sticky-note"></i>
              </div><?php echo $form->textArea($model, 'classification_description', array('size' => 60, 'maxlength' => 500, 'class' => 'form-control')); ?>
            </div><!-- /.input group -->
            <br><?php echo $form->error($model, 'classification_description', array('class' => 'alert alert-danger')); ?>
          </div>
          <div class="form-group col-sm-12">
            <label><?php echo $form->labelEx($model, 'classification_status'); ?></label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-shield"></i>
              </div><?php echo $form->dropDownList($model, 'classification_status', array("1" => "Activo", "0" => "Inactivo"), array('class' => 'form-control')); ?>
            </div><!-- /.input group -->
            <br><?php echo $form->error($model, 'classification_status', array('class' => 'alert alert-danger')); ?>
          </div>
        </div>
    </div>
    <input type="button" id="next-1" name="next" class="next btn btn-block btn-success btn-lg" value="Siguiente" />
</fieldset>

