<?php
/* @var $this ScheduleController */

use App\User\User as U;

$user = U::getInstance();
?>
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

    .tbl_users{ padding: 1%;min-height: 282px;max-height: 282px;overflow-y: scroll;margin-top: 1%; }

    .toggle{ margin-left: 30%; }

    .ui-datepicker{ z-index:1151 !important; }

</style>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'schedulemodal-form',
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
    )
        ));
?>
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <div class="col-md-1"><h4 class="box-title"><b>EVENTO: </b></h4></div>
                    <div class="col-md-11">
                        <?php
                        echo CHtml::textField('Schedulemodal[titlemodal]', '', [
                            'id' => 'Schedulemodal_titlemodal',
                            'class' => 'form-control',
                            'placeholder' => 'Detalle Evento ...',
                            'maxlength' => 300
                        ]);
                        ?>
                    </div>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="col-sm-6">
                            <fieldset style="padding-top: 5%;">

                                <div class="col-sm-5">
                                    <div class="form-group"><label>Fecha Inicio:</label></div>
                                </div>                    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'Schedulemodal[start]',
                                                'language' => 'es',
                                                'options' => array(
                                                    'dateFormat' => 'yy-mm-dd',
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => 'readonly',
                                                    'class' => 'form-control',
                                                    'maxlength' => '10',
                                                    'style' => 'text-align: center;',
                                                    'id' => 'Schedulemodal_start',
                                                ),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <?php
                                            echo CHtml::textField('Schedulemodal[startmm]', '', [
                                                'id' => 'Schedulemodal_startmm',
                                                'class' => 'form-control',
                                                'placeholder' => '01:00',
                                                'style' => 'text-align: center;'
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group"><label>Fecha Fin:</label></div>
                                </div>                    
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'Schedulemodal[end]',
                                                'language' => 'es',
                                                'options' => array(
                                                    'dateFormat' => 'yy-mm-dd',
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => 'readonly',
                                                    'class' => 'form-control',
                                                    'maxlength' => '10',
                                                    'style' => 'text-align: center;',
                                                    'id' => 'Schedulemodal_end',
                                                ),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <?php
                                            echo CHtml::textField('Schedulemodal[endmm]', '', [
                                                'id' => 'Schedulemodal_endmm',
                                                'class' => 'form-control',
                                                'placeholder' => '23:59',
                                                'style' => 'text-align: center;'
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                echo CHtml::hiddenField('Schedulemodal[schedulemodal_id]', '', ['id' => 'Schedulemodal_schedulemodal_id']);
                                echo CHtml::hiddenField('Schedulemodal[backgroundcolor]', 'rgb(60,141,188)', ['id' => 'Schedulemodal_backgroundcolor_modal']);
                                echo CHtml::hiddenField('Schedulemodal[bordercolor]', 'rgb(60,141,188)', ['id' => 'Schedulemodal_bordercolor_modal']);
                                ?>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Todo el día</label>
                                        <div class="input-group" style="padding-left: 50%;">
                                            <input name="Schedulemodal[allday]" id ="Schedulemodal_allday" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Repetir</label> 
                                        <div class="input-group" style="padding-left: 50%;">  
                                            <input name="Schedulemodal[repeat]" id ="Schedulemodal_repeat" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email </label> 
                                        <div class="input-group" style="padding-left: 50%;">  
                                            <input name="Schedulemodal[email]" id ="Schedulemodal_email" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Visible </label> 
                                        <div class="input-group" style="padding-left: 50%;">  
                                            <input name="Schedulemodal[schedulemodal_visible]" id ="Schedulemodal_schedule_visible" class="form-control" type="checkbox" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group"><label>Notificación:</label></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"> 
                                        <div class="input-group">
                                            <?php echo CHtml::dropDownList('Notification[notify_type]', 'Notification_notify_type', array("1" => "Correo", "2" => "Notificación"), array('class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group"> 
                                        <div class="input-group">
                                            <?php
                                            echo CHtml::textField('Notification[notify_time]', '30', [
                                                'id' => 'Notification_notify_time',
                                                'class' => 'form-control',
                                                'placeholder' => '30',
                                                'maxlength' => '3',
                                                'style' => 'text-align: center;'
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <div class="input-group">
                                            <?php echo CHtml::dropDownList('Notification[notify_period]', 'Notification_notify_period', array("1" => "Minutos", "2" => "Horas"), array('class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group"><label>Url:</label></div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group"> 

                                        <?php
                                        echo CHtml::textField('Schedulemodal[url]', '', [
                                            'id' => 'Schedulemodal_url',
                                            'class' => 'form-control',
                                            'placeholder' => 'http://quasarepos.com/'
                                        ]);
                                        ?>

                                    </div>
                                </div>

                            </fieldset>
                        </div>
                        <div class="col-sm-6"'>
                            <fieldset style="padding-top: 5%;">

                                <div class="input-group">
                                    <?php
                                    echo CHtml::textField('usuario', '', [
                                        'id' => 'usuario-autocomplete',
                                        'size' => '40',
                                        'placeholder' => 'Asignar Invitados'
                                    ]);
                                    ?>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-add-user">Asignar</button>
                                    </span>
                                </div>
                                <div>
                                    <div class="tbl_users">
                                        <table id="tablausers" style="width: 100%;" class="table table-striped table">
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <div class="col-sm-12"><p>Color:</p></div>
                                    <div class="col-sm-12">
                                        <ul class="fc-color-picker" id="color-chooser-modal">
                                            <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-block btn-success btn-lg" data-dismiss="modal" id="saveUser">Guardar</button>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-block btn-danger btn-lg" id="delete-event" >Eliminar</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->endWidget(); ?>
<script>
    jQuery(function () {
        $('#user').selectize();
        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default

        $("#color-chooser-modal > li > a").click(function (e) {
            e.preventDefault();
            //Save color
            currColor = $(this).css("color");
            //Add color effect to button
            $('#Schedulemodal_backgroundcolor_modal').val(currColor);
            $('#Schedulemodal_bordercolor_modal').val(currColor);
        });

        $('#Schedulemodal_startmm').timepicker({
            minuteStep: 1,
            template: 'modal',
            appendWidgetTo: 'body',
            showSeconds: true,
            showMeridian: false,
            defaultTime: false
        });

        $('#Schedulemodal_endmm').timepicker({
            minuteStep: 1,
            template: 'modal',
            appendWidgetTo: 'body',
            showSeconds: true,
            showMeridian: false,
            defaultTime: false
        });
    });
    $(function () {
        $('#Schedulemodal_allday').change(function () {
            if ($(this).prop('checked') == true) {
                $('#Schedulemodal_startmm').val('00:00');
                $('#Schedulemodal_endmm').val('00:00');
            } else {
                $('#Schedulemodal_startmm').val('08:00');
                $('#Schedulemodal_endmm').val('09:00');
            }
        });

        $('#Schedulemodal_start').change(function () {
            var repeat = $("#Schedulemodal_repeat").parent().hasClass('off');

            var inicial = $('#Schedulemodal_start').val();
            var final = $('#Schedulemodal_end').val();
            if (inicial > final) {
                $('#Schedulemodal_end').val(inicial);
            }
            if (inicial == final) {

            }
        });
    });
</script>