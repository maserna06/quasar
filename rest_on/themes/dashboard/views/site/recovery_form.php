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
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
            <?php echo $form->textField($model,'user_email',array('size'=>50,'maxlength'=>50,'class'=>'form-control','placeholder'=>'Email','type'=>'email'));?>
        </div>
        <br><?php echo $form->error($model,'user_email',array('class'=>'alert alert-danger'));?>
    </div>
    <div class="form-group">
        <input name="recover-submit" class="btn btn-lg btn-success btn-block" value="Restablecer contraseña" type="submit">
    </div>

    <input type="hidden" class="hide" name="token" id="token" value=""> 
<?php $this->endWidget(); ?>