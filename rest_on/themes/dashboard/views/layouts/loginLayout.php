<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition ">

	        <div class="col-xs-12 col-md-12 col-lg-12" style="position: absolute;z-index: 1000;width: 100%;top: 0;background: rgba(0, 0, 0, .5)">
	            <div class="col-xs-4 col-md-4 col-lg-4 pull-left" style="padding-bottom: 1%">
	                <a href="http://quasarepos.com" target="_blank" style="color:#FFF;"><h1><b>QUASAR</b></h1></a>
	            </div>
	            <div class="col-xs-8 col-md-8 col-lg-8 pull-right" style="text-align: right;padding: 1.2%">
	                <a href="#" id="btn_register" class="btn btn-lg btn-success"><b>Registrese</b></a>
	            </div>
	        </div>

	        <!--<div class="video" style="height: 100%;width: 100%;background-image: url(<?php #echo Yii::app()->theme->baseUrl; ?>/dist/img/bg__dots.png);position: absolute;z-index: 2;opacity: .5;top: 0"></div>-->

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            
            <div class="col-xs-12 col-md-12 col-lg-12" style=" z-index: 101;">
               
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="login-box">
                            <!-- /.login-logo -->
                            <?php echo $content; ?>   
                            <!-- /.login-box-body -->
                        </div>
                        <!-- /.login-box -->
                    </div>
                
            </div>

            <div class="video" style=" z-index: 1;">
                <video preload="auto" autoplay="" loop="" class="fillWidth fadeIn animated" poster="<?php echo Yii::app()->theme->baseUrl; ?>/dist/mp4/Coffee-Shot.jpg" style="position: absolute; height: auto; width: 100%; left: 50%; -webkit-transform: translate3d(-50%, 0, 0); transform: translate3d(-50%, 0, 0); z-index: 1; top: 0;">
                    <source src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/mp4/Coffee-Shot.mp4" type="video/mp4">
                    <source src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/mp4/Coffee-Shot.webm" type="video/webm">

                </video>
            </div>

    </body>
</html>
 <?php $this->renderPartial('../_modal'); ?>
<?php $this->renderPartial('new_register') ?>

<!-- jQuery 2.2.3 -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/iCheck/icheck.min.js"></script>
<!-- js personalizado jcubides -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/jc.js"></script>
<script>

    $('#btn_register').bind('click', false);
    $('#btn_register').on('click', function (e) {
        e.preventDefault();
        $("#formRegister").html('');
        $.ajax({
            url: "<?php echo $this->createUrl('/user/NewRegister') ?>",
            success: function (result) {
                $("#formRegister").html(result);
                $(".modal-dialog").width("70%");
            }
        });
        $("#myModalRegister").modal({keyboard: false});
    });

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
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
<style>
    .modal-backdrop{
        z-index: 50 !important;
    }
</style>