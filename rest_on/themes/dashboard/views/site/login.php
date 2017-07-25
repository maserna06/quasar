<?php
echo CHtml::hiddenField("confirmacion", (Yii::app()->getSession()->get('confirmacion')) ? Yii::app()->getSession()->get('confirmacion') : 0);
Yii::app()->getSession()->remove('confirmacion');
?>
<div class="login-box-body" style=" background: transparent !important;">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'htmlOptions' => array("class" => "form",
            'onsubmit' => "return false;", /* Disable normal form submit */
        ),
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="form-group has-feedback">
      <!--<input type="email" class="form-control" placeholder="Email">-->
        <?php echo $form->textField($model, 'user_name', array('placeholder' => 'Nombre de Usuario *', 'class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <!--<input type="password" class="form-control" placeholder="Password">-->
        <?php echo $form->passwordField($model, 'user_passwordhash', array('placeholder' => 'Contraseña *', 'class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">

        <div class="col-xs-12">
            <!--<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>-->
            <?php echo CHtml::submitButton('Acceder', array('class' => 'btn btn-lg btn-success btn-block btn-flat', 'onclick' => 'sendLogin();')); ?>
        </div>
        <!-- /.col -->
    </div>
    <?php $this->endWidget(); ?>
    <a href="#" id="resetPassword" style=" color: #FFF">Olvide mi contraseña</a>
    <br><br>
    <br><br>

    <div class="social-auth-links text-center">
      <p style="color: #FFF;">Siguenos en:</p>
      <a href="#" class="btn btn-lg btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i>
        Facebook</a>
      <a href="#" class="btn btn-lg btn-block btn-social btn-google btn-flat"><i class="fa fa-youtube"></i>
        Youtube</a>
    </div>

    

</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<?php $this->renderPartial('../_modal'); ?> 
<?php $this->renderPartial('password_ recovery') ?>
<a class="hide" id="lanzarCOnf" onclick="lanzar()">aaa</a>

<script>

    function sendLogin(form, hasError) {
        url = $("#login-form").attr('action');
        data = $("#login-form").serialize();

        if (!hasError) {
            // No errors! Do your post and stuff
            // FYI, this will NOT set $_POST['ajax']... 
            //$('#exit').click();
            $.post(url, data, function (res) {
                var datos = $.parseJSON(res);
                $("#bodyArchivos").html("<div class='col-md-12'>" + datos['mensaje'] + "</div>");
                $("#myModal").modal({keyboard: false});
                $(".modal-dialog").width("40%");
                $(".modal-title").html("Información");
                $(".modal-header").removeClass("alert alert-success");
                $(".modal-header").addClass("alert alert-" + datos['estado']);
                $(".modal-header").show();
                setTimeout(function () {
                    $("#myModal").modal('hide');
                    $(".modal-header").removeClass("alert alert-" + datos['estado']);
                    $(".modal-header").addClass("alert alert-success");
                    if (datos['estado'] == 'success') {
                        document.getElementById("login-form").reset();
                        window.location.href = "index";
                    }
                }, 2500);

            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
    
    $('#resetPassword').bind('click', false);
    $('#resetPassword').on('click', function (e) {
        e.preventDefault();
        $("#formPassword").html('');
        $.ajax({
            url: "<?php echo $this->createUrl('/user/RecoveryPassword') ?>",
            success: function (result) {
                $("#formPassword").html(result);
                $(".modal-dialog").width("40%");
            }
        });
        $("#myModalPassword").modal({keyboard: false});
    });
   window.onload = function (){
        var confirmacion = $('#confirmacion').val();
        if (confirmacion != 0) {
            var datos = $.parseJSON(confirmacion);
            $("#bodyArchivos").html("<div class='col-md-12'>" + datos['mensaje'] + "</div>");
            $("#myModal").modal({keyboard: false});
            $(".modal-dialog").width("40%");
            $(".modal-title").html("Información");
            $(".modal-header").addClass("alert alert-" + datos['estado']);
            $(".modal-header").show();
            $(".modal-footer").html("");
            setTimeout(function () {
                $("#myModal").modal('hide');
                $(".modal-header").removeClass("alert alert-" + datos['estado']);
                $(".modal-header").addClass("alert alert-success");
            }, 5000);
        }
    }
    

</script>