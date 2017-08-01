<?php
/* @var $this CompaniesController */
/* @var $model Companies */
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/dist/js/html2canvas.min.js');


Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/bootstrap/css/bootstrap.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/dist/css/AdminLTE.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css');

use App\User\User as U;

$user = U::getInstance();
$isSuper = $user->isSuper;
$visible = $user->isSuper;

$this->menu = array(
    array('label' => 'Crear Empresa', 'url' => array('create'), 'visible' => $visible),
    array('label' => 'Actualizar Empresa', 'url' => array('update', 'id' => $model->company_id)),
    array('label' => ($isSuper ? 'Administrar' : 'Ver') . ' Empresas', 'url' => array('index')),
);
?>
<section class="content">
    <div class="invoice" id="section-to-print"><!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-file-text"></i> Detalle de Empresa
                    <small class="pull-right">Fecha: <?php echo date('Y-m-d'); ?></small>
                </h2>
            </div><!-- /.col -->
        </div><!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                Empresa      
                <address>
                    <strong><?php echo $model->company_name; ?></strong><br>
                    Nit: <?php echo $model->company_id; ?><br>
                    <br>
                    Direccion: <?php echo $model->company_address; ?><br>
                    Telefono: <?php echo $model->company_phone; ?>
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                De
                <address>
                    <strong>
                        <?php
                        if (!empty($model->city_id)) {
                            $city = Cities::model()->findByPk($model->city_id);
                            echo $city->city_name;
                        } else {
                            echo "";
                        }
                        echo ", ";
                        ?></strong>
                    <?php
                    if (!empty($model->deparment_id)) {
                        $deparment = Departaments::model()->findByPk($model->deparment_id);
                        echo $deparment->deparment_name;
                    } else {
                        echo "";
                    }
                    ?>          
                    <br>
                    <br>
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Otros Datos</b><br>
                <br>      
                <b>Url: </b><a href="<?php echo $model->company_url; ?>" target="_blank"><?php echo $model->company_url; ?></a><br>
                <b>Estado:</b> 
                <?php
                if ($model->company_status == "1") {
                    echo "Activo";
                } else {
                    echo "Inactivo";
                }
                ?>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-6">
                <h2 class="page-header">
                    <i class="fa fa-picture-o"></i> Logo de la Empresa
                </h2>
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4"></div>
                            <div class="col-xs-4">
                                <?php
                                $img = ($model->company_logo) ? $model->company_logo : 'company-350x350.png';
                                echo CHtml::image(Yii::app()->theme->baseUrl . '/dist/img/' . $img, '', array('class' => 'img-thumbnail', "data-toggle" => "tooltip", "title" => $model->company_name));
                                ?>
                            </div>
                            <div class="col-xs-4"></div>
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-6">
                <h2 class="page-header">
                    <i class="fa fa-users"></i> Panel de Usuarios
                </h2> 
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <?php echo $this->renderPartial('_users', array('users' => $users)); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- info row -->
        <div class="row">

        </div>
        <!-- this row will not appear when printing -->
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="#" target="_blank" class="btn btn-default printing" data-section="section-to-print"><i class="fa fa-print"></i> Imprimir</a>

                <a href="javascript:;" target="_blank" class="btn btn-primary pull-right to-canvas" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generar PDF
                </a>
            </div>
        </div>

        <form id="form_save_pdf" name="form_save_pdf" target="_blank" method="post" action="<?= Yii::app()->createAbsoluteUrl('companies/' . $model->company_id, ['format' => 'pdf']) ?>">
            <input type="hidden" name="image" id="image-to-pdf" />
        </form>
    </div>
</section>
<?php echo $this->renderPartial('../_modal'); ?> 
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bootstrap-switch/docs/js/highlight.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bootstrap-switch/dist/js/bootstrap-switch.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bootstrap-switch/docs/js/main.js"></script>
<script type="text/javascript">
    jQuery(function ($) {

        $('.to-canvas').on('click', function () {
            var invoice = $('.invoice');
            $('.no-print').hide();

            Modal.show('Generando archivo PDF...<br /> Debe habilitar las ventanas emergentes para poder visualizarlo.');
            html2canvas(invoice[0], {
                onrendered: function (canvas) {
                    Modal.show('El achivo se ha generado correctamente. <br />Si no lo visualiza debe habilitar las ventanas emergentes.');
                    $('.no-print').show();

                    var form = document.form_save_pdf;
                    form.image.value = canvas.toDataURL("image/png");
                    form.submit();
                }
            });
        });
        $('.user-edit').on('click', function (e) {

            $("#bodyArchivos").html('');
            var id = $(this).attr("id");
            $.ajax({
                url: "<?php echo $this->createUrl('/user/DataUser') ?>",
                data: {
                    id: id
                },
                success: function (result) {
                    $("#bodyArchivos").html(result);
                    $("#myModal").modal({keyboard: false});
                    $(".modal-dialog").width("80%");
                    $(".modal-title").html("Datos de Usuario");
                    $(".modal-footer").html("<div><div class='col-md-6'><div class='form-group'><input class='btn btn-block btn-success btn-lg saveEditUser' name='saveUser[]' name='saveUser' type='button' value='Guardar' /></div></div><div class='col-md-6'><div class='form-group'><input class='btn btn-block btn-danger btn-lg' data-dismiss='modal' type='button' value='Cancelar' /></div></div></div>");
                }
            });


        });

        $("#myModal").on('click','.saveEditUser',function(){
        var data = $("#user-form").serialize();
        console.log(data);
         $.ajax({
           type: "POST",
           url: $("#user-form").attr('action'),
           data: data,
           success: function(data)
           {
               $('#myModal').modal('hide');
           }
         });
        });
         

    });


</script>