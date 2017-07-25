
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'htmlOptions' => array("class" => "form",
        'onsubmit' => "return false;", /* Disable normal form submit */
        'enctype' => 'multipart/form-data'
    ),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>
<section class="allSection">
    <div class="col-sm-12">
        <div class="tab-pane active" id="settings">

            <div class="col-sm-6">  
                <div class="row-fluid">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> Información Personal
                        <small class="pull-right"></small>
                    </h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre de Usuario</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bookmark"></i>
                                    </div>
                                    <?php echo $form->textField($model, 'user_name', array('class' => 'form-control', 'placeholder' => 'user-name')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'user_name', array('class' => 'alert alert-danger')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <?php echo $form->textField($model, 'user_email', array('class' => 'form-control', 'placeholder' => 'admin@quasarepos.com')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'user_email', array('class' => 'alert alert-danger')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-shield"></i>
                                    </div>
                                    <?php echo $form->dropDownList($model, 'user_status', array("1" => "Activo", "0" => "Inactivo"), array('class' => 'form-control')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'user_email', array('class' => 'alert alert-danger')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nueva Contraseña</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div><!--<?php #echo $form->textField($model, 'user_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control'));      ?>-->
                                    <?php echo $form->passwordField($model, 'new_password', array('class' => 'form-control', 'placeholder' => 'Ingrese Nueva Contraseña')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'new_password', array('class' => 'alert alert-danger')); ?>
                                <!--<br><?php #echo $form->error($model, 'user_name', array('class' => 'alert alert-danger'));      ?>-->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Confirme Contraseña</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div><!--<?php #echo $form->textField($model, 'user_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control'));      ?>-->
                                    <?php echo $form->passwordField($model, 'repeat_password', array('class' => 'form-control', 'placeholder' => 'Confirme Contraseña')); ?>
                                </div><!-- /.input group -->
                                <br><?php echo $form->error($model, 'repeat_password', array('class' => 'alert alert-danger')); ?>
                                <!--<br><?php #echo $form->error($model, 'user_name', array('class' => 'alert alert-danger'));      ?>-->
                            </div>
                        </div>
                        <div class="col-md-12 btn_changed hide">
                            <div class="col-md-12">
                                <div class="form-group">            
                                    <?php echo CHtml::submitButton('Cambiar Contraseña', array('class' => 'btn btn-block btn-success btn-lg')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
            <div class="col-sm-6">  
                <div class="row-fluid">
                    <h2 class="page-header">
                        <i class="fa fa-group"></i> Roles
                        <small class="pull-right">Estado</small>
                    </h2>
                    <br>
                    <?php echo $this->renderPartial('/companies/_roles', ['model' => $model]); ?>
                </div>
            </div>

        </div>
    </div>
</section>


