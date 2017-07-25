<style type="text/css">

  .modal {
    text-align: center;
    padding: 0!important;
  }

  .modal:before {
    content: '';
    display: inline-block;
    height: 100%;
    vertical-align: middle;
    margin-right: -4px;
  }

  .modal-dialog {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
  }

</style>
<div class="modal fade" id="modal-config" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?php      
      $form = $this->beginWidget('CActiveForm', array(
          'id' => 'wharehouses-form',
          'htmlOptions' => array("class" => "form",
              'onsubmit' => "return false;", /* Disable normal form submit */
          ),
          // Please note: When you enable ajax validation, make sure the corresponding
          // controller action is handling ajax validation correctly.
          // There is a call to performAjaxValidation() commented in generated controller code.
          // See class documentation of CActiveForm for details on this.
          'enableAjaxValidation' => false,
          'enableClientValidation' => true,
          'clientOptions' => array(
              'validateOnSubmit' => true,
              'validateOnChange' => true,
              'validateOnType' => true,
              'afterValidate' => 'js:mySubmitFormFunction', // Your JS function to submit form
          )
      ));
      ?>

      <div class="modal-header" id="header-config">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" >&times;</span>
        </button>
        <h4 class="box-title">Configurar Bodega</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-md-offset-0">
            <div class="col-xs-12 main_">
              <div class="form-group">
                <!--<div class="input-group">-->
                <label class="col-sm-12">
                  <div class="col-sm-5">MultiCaja</div>
                  <input name="WharehousesUser[wharehouse_id]" id ="WharehousesUser_wharehouse_id" class="form-control" type="hidden">
                  <input name="WharehousesUser[user_id]" id ="WharehousesUser_user_id" class="form-control" type="hidden">
                  <input name="WharehousesUser[multicash]" id ="WharehousesUser_multicash" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                </label>
                <!--</div>-->
              </div>

              <div class="form-group">
                <!--<div class="input-group">-->
                <label class="col-sm-12">
                  <div class="col-sm-5">Cierre Diario</div>
                  <input name="WharehousesUser[daily_close]" id ="WharehousesUser_daily_close" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                </label>
                <!--</div>-->
              </div>

              <div class="form-group">
                <!--<div class="input-group">-->
                <label class="col-sm-12">
                  <div class="col-sm-5">Datafono</div>
                  <input name="WharehousesUser[apply_datafono]" id ="WharehousesUser_apply_datafono" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                </label>
                <!--</div>-->
              </div>                            
            </div>
            <div class="col-xs-4 cash hide">
              <div class="form-group">
                <label>Ip Caja</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-signal"></i>
                  </div>
                  <?php
                  echo CHtml::textField('WharehousesUser[cash_ip]', '', [
                      'id' => 'WharehousesUser_cash_ip',
                      'class' => 'form-control',
                      'placeholder' => '190.168.213.20',
                      'pattern' => '^([0-9]{1,3}\.){3}[0-9]{1,3}$'
                  ]);
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label>Puerto Caja</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-share-alt-square"></i>
                  </div>
                  <?php
                  echo CHtml::textField('WharehousesUser[cash_port]', '', [
                      'id' => 'WharehousesUser_cash_port',
                      'class' => 'form-control',
                      'placeholder' => '5237'
                  ]);
                  ?>
                </div>
              </div>

            </div>
            <div class="col-xs-4 cash hide">

              <div class="form-group">
                <label>Ip Datafono</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-signal"></i>
                  </div>
                  <?php
                  echo CHtml::textField('WharehousesUser[dataphone_ip]', '', [
                      'id' => 'WharehousesUser_dataphone_ip',
                      'class' => 'form-control',
                      'placeholder' => '192.113.0.80',
                      'pattern' => '^([0-9]{1,3}\.){3}[0-9]{1,3}$'
                  ]);
                  ?>
                </div>
                <br><?php // echo $form->error($model,'WharehousesUser[dataphone_ip]',array('class'=>'alert alert-danger'));   ?>
              </div>

              <div class="form-group">
                <label>Puerto Datafono</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-share-alt-square"></i>
                  </div>
                  <?php
                  echo CHtml::textField('WharehousesUser[dataphone_port]', '', [
                      'id' => 'WharehousesUser_dataphone_port',
                      'class' => 'form-control',
                      'placeholder' => '3333'
                  ]);
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label>Nombre Datafono</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-bookmark"></i>
                  </div>
                  <?php
                  echo CHtml::textField('WharehousesUser[dataphone_name]', '', [
                      'id' => 'WharehousesUser_dataphone_name',
                      'class' => 'form-control',
                      'placeholder' => 'DATA01'
                  ]);
                  ?>
                </div>
              </div>
            </div>        
          </div>
        </div>
      </div>
      <div class="modal-footer" id="footer-config">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <button type="button" class="btn btn-block btn-success btn-lg" data-dismiss="modal" id="saveVendor">Guardar</button>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <?php echo CHtml::submitButton("Cancelar", array("class" => "btn btn-block btn-danger btn-lg", "data-dismiss" => "modal", "id" => "exit")); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>