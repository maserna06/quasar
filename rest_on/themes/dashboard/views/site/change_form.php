<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    )
        ));
?>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-key"></i></span>
        <?php echo $form->passwordField($model, 'old_password', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Contraseña Temporal', 'type' => 'password')); ?>
        <?php echo $form->error($model, 'old_password', array('class' => 'alert alert-danger')); ?>
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-key"></i></span>
        <?php echo $form->passwordField($model, 'new_password', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Nueva Contraseña', 'type' => 'password')); ?>
        <?php echo $form->error($model, 'new_password', array('class' => 'alert alert-danger')); ?>
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-key"></i></span>
        <?php echo $form->passwordField($model, 'repeat_password', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Confirmar Contraseña', 'type' => 'password')); ?>
        <?php echo $form->error($model, 'repeat_password', array('class' => 'alert alert-danger')); ?>
    </div>
</div>
<div class="form-group">
    <input name="recover-submit" class="btn btn-lg btn-success btn-block" value="Restablecer contraseña" type="submit">
</div>
<?php $this->endWidget(); ?>