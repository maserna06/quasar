<?php
/* @var $this ClassificationController */
/* @var $model Classification */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

$this->menu = array(
    array('label' => 'Crear Clasificacion', 'url' => array('create'), 'visible' => $visible),
    array('label' => ($isAdmin?'Administrar':'Ver').' Clasificaciones', 'url' => array('index')),
);
?>
<!-- jQuery 2.2.3 -->
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/slide.css">
<section class="content" style="min-height: 2000px;">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'classification-form',
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
    ),
        ));
?>
<ul id="progressbar">
    <li class="active">INFORMACIÓN GENERAL</li>
    <li>PRODUCTOS</li>
    <li>BODEGAS</li>
</ul>

<?php $this->renderPartial('sliders/slide1', array('model' => $model, 'form' => $form)); ?>
<?php $this->renderPartial('sliders/slide2', array('products' => $products, 'form' => $form)); ?>
<?php $this->renderPartial('sliders/slide3', array('wharehouses' => $wharehouses, 'form' => $form)); ?>

<!-- Modal para validar cancelación de formulario -->
<?php $this->renderPartial('../_modal_cancel'); ?>
<?php $this->renderPartial('../_modal'); ?> 

<?php $this->endWidget(); ?>
</section>

<script>
    function send(form, hasError) {
        url = $("#classification-form").attr('action');
        data = $("#classification-form").serialize();

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
                        document.getElementById("classification-form").reset();
                    }
                }, 2500);

            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }
</script>

<script languaje="javascript">
  jQuery(function ($) {
    var checkbox = $('input[type="checkbox"]');
    $.each(checkbox, function (key, item) {
      parentActive(item);
      $(item).on('click', function () {
        parentActive(item);
      });
    });
    function parentActive(e) {
      $parent = $(e).parents('.display-product');
      if ($(e).is(':checked')) {
        $($parent).addClass('active');
        $($parent).find('.toogle-check').addClass('btn-success').removeClass('btn-danger').html('On');
      } else {
        $($parent).removeClass('active');
        $($parent).find('.toogle-check').removeClass('btn-success').addClass('btn-danger').html('Off');
      }
    }
    $('.small').children('h3').slimScroll({
      height: '45px'
    });
    $('.smalls').children('h3').slimScroll({
      height: '45px'
    });
  });
</script>

<script>
    $(function () {

        //jQuery time
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches

        $(".next").click(function () {

            var idSlide = $(this).attr('id');
            var slide = idSlide.split('-');
            slide = '#slide-' + slide[1];
            var todosHijos = $(slide).find('*').hasClass('error');
            if (todosHijos) {
                $("#bodyArchivos").html("<div class='col-md-12'>Por favor diligencie todos los campos marcados con *.</div>");
            $("#myModal").modal({keyboard: false});
            $(".modal-dialog").width("40%");
            $(".modal-title").html("Información");
            $(".modal-header").addClass("alert alert-danger");
            $(".modal-header").show();
            $(".modal-footer").html("");
            setTimeout(function (){
                $("#myModal").modal('hide');
                $(".modal-header").removeClass("alert alert-danger")
            }, 4000);
            } else {
                if (animating)
                    return false;
                animating = true;

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                //activate next step on progressbar using the index of next_fs
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function (now, mx) {
                        //as the opacity of current_fs reduces to 0 - stored in "now"
                        //1. scale current_fs down to 80%
                        scale = 1 - (1 - now) * 0.2;
                        //2. bring next_fs from the right(50%)
                        left = (now * 50) + "%";
                        //3. increase opacity of next_fs to 1 as it moves in
                        opacity = 1 - now;
                        current_fs.css({'transform': 'scale(' + scale + ')'});
                        next_fs.css({'left': left, 'opacity': opacity});
                    },
                    duration: 800,
                    complete: function () {
                        current_fs.hide();
                        animating = false;
                    },
                    //this comes from the custom easing plugin
                    easing: 'easeInOutBack'
                });
            }
        });

        $(".previous").click(function () {
            if (animating)
                return false;
            animating = true;

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({'left': left});
                    previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".submit").click(function () {
            return false;
        })

    });
</script>
