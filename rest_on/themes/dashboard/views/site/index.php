<?php

use App\User\User as U;

$user = U::getInstance();
/*
 * datos para modal de confirmación
 */
echo CHtml::hiddenField("confirmacion", (Yii::app()->getSession()->get('confirmacion')) ? Yii::app()->getSession()->get('confirmacion') : 0);
Yii::app()->getSession()->remove('confirmacion');
?>                        
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Sistema POS <small>Panel de Control</small> </h1>

    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Tablero</li>
    </ol>
</section>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <?php if (!($user->isVendor && (!$user->isSuper && !$user->isAdmin && !$user->isSupervisor))) { ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php
                            if ($user->isSuper) {
                                $condition = "purchase_status <> 3 ";
                            } else {
                                if ($user->isVendor) {
                                    $condition = "purchase_status <> 3 AND company_id = " . $user->companyId .
                                            " AND user_id = " . Yii::app()->user->getId();
                                } else {
                                    $condition = "purchase_status <> 3 AND company_id = " . $user->companyId;
                                }
                            }
                            $purchases = new CActiveDataProvider('Purchases', array(
                                'criteria' => array(
                                    'condition' => $condition,
                                ),
                            ));
                            $max = $purchases->getTotalItemCount();
                            echo $max;
                            ?></h3>
                        <p>Compras</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <div id="purchases_" class="small-box-footer" style="cursor: pointer;">Mas informacion <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>
        <?php } ?>
        <!-- ./col -->
        <div class="col-lg-<?= ($user->isVendor && (!$user->isSuper && !$user->isAdmin && !$user->isSupervisor)) ? 6 : 3 ?> col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><span id="sales-increment"></span> %</h3>

                    <p>Aumento de Ventas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>        
                <div id="sales_" class="small-box-footer" style="cursor: pointer;">Mas informacion <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-<?= ($user->isVendor && (!$user->isSuper && !$user->isAdmin && !$user->isSupervisor)) ? 6 : 3 ?> col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php
                        $condition = "company_id = " . $user->companyId;
                        $criteria = new CDbCriteria();
                        $criteria->alias = "Auth";
                        $criteria->select = "*";
                        $criteria->join = "INNER JOIN AuthAssignment a ON a.userid = user_id AND a.itemname <> 'supplier' AND a.itemname <> 'customer'";
                        $criteria->condition = $condition;
                        $criteria->group = "user_id";

                        $users = new CActiveDataProvider("User", array("criteria" => $criteria));
                        echo $users->getTotalItemCount();
                        ?>
                    </h3>

                    <p>Usuarios Registrados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <div id="users_" class="small-box-footer" style="cursor: pointer;">Mas informacion <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <!-- ./col -->
        <?php if (!($user->isVendor && (!$user->isSuper && !$user->isAdmin && !$user->isSupervisor))) { ?>
            <div class="col-lg-<?= ($user->isVendor && (!$user->isSuper && !$user->isAdmin && !$user->isSupervisor)) ? 4 : 3 ?> col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>25</h3>

                        <p>Informes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <div id="reports_" class="small-box-footer" style="cursor: pointer;">Mas informacion <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>
        <?php } ?>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">

        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title">Lista de Tareas</h3>

                    <div class="box-tools pull-right">
                        <ul class="pagination pagination-sm inline">
                            <li><a href="#">&laquo;</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-body">
                    <ul class="todo-list">
                    </ul>
                </div>
                <div class="box-footer clearfix no-border">
                    <button type="button" class="btn btn-default pull-right addTask"><i class="fa fa-plus"></i> Agregar tarea</button>
                </div>
            </div>
            <!-- /.box -->

            <!-- quick email widget -->
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-envelope"></i>

                    <h3 class="box-title">Correo Electronico</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Quitar">
                            <i class="fa fa-times"></i></button>
                    </div>
                    <!-- /. tools -->
                </div>
                <div class="box-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" name="emailto" placeholder="Email a:">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" placeholder="Asunto">
                        </div>
                        <div>
                            <textarea class="textarea" placeholder="Mensaje" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </form>
                </div>
                <div class="box-footer clearfix">
                    <button type="button" class="pull-right btn btn-default" id="sendEmail">Enviar
                        <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

            <!-- solid sales graph -->
            <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                    <i class="fa fa-th"></i>

                    <h3 class="box-title">Grafico de Ventas</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body border-radius-none">
                    <div class="chart" id="line-chart" style="height: 250px;">
                        <?php $this->renderPartial('salesCharts',array('model'=>$model,'title'=>'Ventas')) ?>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-border">
                    <div class="row">
                        <div class="col-xs-4 text-center salesChart" style="border-right: 1px solid #f4f4f4" >
                            <input type="text" class="knob" data-readonly="true" value="0" data-width="60" data-height="60" data-fgColor="#39CCCC">

                            <div class="knob-label">Pedidos</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                            <input type="text" class="knob" data-readonly="true" value="0" data-width="60" data-height="60" data-fgColor="#39CCCC">

                            <div class="knob-label">Remisiones</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-xs-4 text-center">
                            <input type="text" class="knob" data-readonly="true" value="0" data-width="60" data-height="60" data-fgColor="#39CCCC">

                            <div class="knob-label">Ventas</div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->

            <!-- Chat box -->
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-comments-o"></i>

                    <h3 class="box-title">Chat</h3>

                    <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                        <div class="btn-group" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                        </div>
                    </div>
                </div>
                <div class="box-body chat" id="chat-box">
                    <!-- <div class="item">
                        <img src="<?php #echo Yii::app()->theme->baseUrl;   ?>/dist/img/user4-128x128.jpg" alt="user image" class="online">
                        <p class="message">
                            <a href="#" class="name">
                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                                Andres Arias
                            </a>
                            Me gustaría conocerte para discutir las últimas noticias sobre
                            la llegada del nuevo sitio. Dicen que va a ser una de las
                            Los mejores sitios en el mercado.
                        </p>
                        <div class="attachment">
                            <h4>Adjuntos:</h4>
                            <p class="filename">
                                Theme-thumbnail-image.jpg
                            </p>
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary btn-sm btn-flat">Abrir</button>
                            </div>
                        </div>
                    </div>-->
                    <!--<div class="item">
                        <img src="<?php #echo Yii::app()->theme->baseUrl;   ?>/dist/img/user3-128x128.jpg" alt="user image" class="offline">

                        <p class="message">
                            <a href="#" class="name">
                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>
                                Daniel Ciro
                            </a>
                            Me gustaría conocerte para discutir las últimas noticias sobre
                            la llegada del nuevo sitio. Dicen que va a ser una de las
                            Los mejores sitios en el mercado.
                        </p>
                    </div>-->
                    <!--<div class="item">
                        <img src="<?php #echo Yii::app()->theme->baseUrl;   ?>/dist/img/user2-160x160.jpg" alt="user image" class="offline">
                        <p class="message">
                            <a href="#" class="name">
                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                                Alejandro Gomez
                            </a>
                            Me gustaría conocerte para discutir las últimas noticias sobre
                            la llegada del nuevo sitio. Dicen que va a ser una de las
                            Los mejores sitios en el mercado.
                        </p>
                    </div>-->
                </div>
                <!-- /.chat -->
                <div class="box-footer">
                    <div class="input-group">
                        <input class="form-control" placeholder="Tipo de mensaje...">

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box (chat box) -->

        </section>
        <!-- right col -->
    </div> 

    <!-- /.row (main row) -->
</div>
</section>
<?php $this->renderPartial('../_modal'); ?>
<?php $this->renderPartial('task'); ?>
<?php $this->renderPartial('purchases'); ?>
<?php $this->renderPartial('sales'); ?>
<?php $this->renderPartial('users'); ?>
<?php $this->renderPartial('reports'); ?>
<script>
    $('.salesChart').click(function(){
        $.ajax({
            url: "<?php echo $this->createUrl('/sales/indexCharts/1') ?>",
            success: function (result) {
                $("#line-chart").html(result);
//                jQuery.noConflict();
//                $("#myModal").modal({keyboard: false});
//                $(".modal-dialog").width("60%");
//                $(".modal-title").html("Crear Cliente");
//                $(".modal-footer").html("");
            }
        });
    });
    window.onload = function () {
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

    function sendAll(form, hasError) {
        data = $("#taskmodal-form").serialize();
        var formData = new FormData(document.getElementById("taskmodal-form"));
        if (!hasError) {
            //Get value and make sure it is not null
            var title_ = $("#Taskmodal_titlemodal").val();
            if (title_.length == 0) {
                return;
            }
            //Load All Events by User
            $.ajax({
                url: '<?= Yii::app()->createUrl('site/addtaskall') ?>',
                method: 'post',
                dataType: "html",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var datos = $.parseJSON(response);
                    if (datos['estado'] == 'success') {
                        var id = datos['mensaje'];
                        //Close Modal
                        $('#modal-task').modal('hide');
                        var title = $("#Taskmodal_titlemodal").val();
                        var start = $("#Taskmodal_start").val() + " " + $("#Taskmodal_startmm").val().substr(0, 5);
                        var today = (new Date()).toISOString().slice(0, 10),
                                fecha1 = moment(start.substr(0, 10)),
                                fecha2 = moment(today.substr(0, 10)),
                                dias = fecha2.diff(fecha1, 'days');
                        var backgroundcolor = $("#Taskmodal_backgroundcolor_modal").val();

                        if (dias < 0)
                            dias = (dias * -1);

                        //Remove Element
                        $("#task_" + id).remove();
                        //Add Element
                        $(".todo-list").append('<li id="task_' + id + '"><span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span><input type="checkbox" value="" style="min-height: 0;width: 3% !important;"><span class="text">' + title + '</span><small class="label" style="background-color:' + backgroundcolor + '"><i class="fa fa-clock-o"></i> ' + dias + ' dias</small><div class="tools"><i class="fa fa-edit" id="' + id + '"></i><i class="fa fa-trash-o" id="' + id + '"></i></div></li>');

                        document.getElementById("taskmodal-form").reset();
                    }
                }
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }

    $(function () {
        var $table = $('#tablausers tbody'),
                $usuario = $('#usuario-autocomplete'),
                $addUserBtn = $('.btn-add-user'),
                $saveBtn = $('#saveTask'),
                users_ = [],
                template = null,
                currentUserSelected = null;

        //Load All Task By User
        $.ajax({
            url: "site/TaskbyUser",
            type: "post",
            success: function (response) {
                var i, task_id, title, start, end, backgroundcolor, bordercolor, task_progress;
                for (i = 0; i < response.TaskbyUser.length; i++) {
                    $.each(response.TaskbyUser[i], function (key, value) {
                        switch (key)
                        {
                            case 'task_id' :
                                task_id = value;
                                break;
                            case 'title' :
                                title = value;
                                break;
                            case 'start' :
                                start = value;
                                break;
                            case 'end' :
                                end = value;
                                break;
                            case 'backgroundcolor' :
                                backgroundcolor = value;
                                break;
                            case 'bordercolor' :
                                bordercolor = value;
                                break;
                            case 'task_progress' :
                                task_progress = value;
                                break;
                        }
                    })
                    var today = (new Date()).toISOString().slice(0, 10),
                            fecha1 = moment(start.substr(0, 10)),
                            fecha2 = moment(today.substr(0, 10)),
                            dias = fecha2.diff(fecha1, 'days');

                    if (dias < 0)
                        dias = (dias * -1);

                    $(".todo-list").append('<li id="task_' + task_id + '"><span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span><input type="checkbox" value="" style="min-height: 0;width: 3% !important;"><span class="text">' + title + '</span><small class="label" style="background-color:' + backgroundcolor + '"><i class="fa fa-clock-o"></i> ' + dias + ' dias</small><div class="tools"><i class="fa fa-edit" id="' + task_id + '"></i><i class="fa fa-trash-o" id="' + task_id + '"></i></div></li>');
                }
            }
        });

        //AutoComplete Users
        $usuario.autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: '<?= $this->createUrl('autocomplete') ?>',
                    method: 'post',
                    data: {
                        term: request.term
                    },
                    dataType: 'json',
                    success: function (data) {
                        response(data);
                    }
                });
            },
            focus: function (e, ui) {
                $usuario.val(ui.item.user_name);
                return false;
            },
            select: function (e, ui) {
                $usuario.val(ui.item.user_name);
                currentUserSelected = ui.item;
                return false;
            }
        })
                .autocomplete("instance")._renderItem = function (ul, item) {
            return $('<li />')
                    .text(item.user_name)
                    .appendTo(ul);
        };

        //Not ENTER submit
        $('form').keypress(function (e) {
            if (e == 13) {
                return false;
            }
        });

        $('input').keypress(function (e) {
            if (e.which == 13) {
                return false;
            }
        });

        //Add User Event
        $addUserBtn.on('click', function (e) {
            e.preventDefault();
            if (!currentUserSelected)
                return false;

            var userId = currentUserSelected.user_id,
                    userName = currentUserSelected.user_name,
                    userEvent = {
                        user_id: userId,
                        name: userName
                    };

            $usuario.val('');
            currentUserSelected = null;
            if (userExists(userEvent))
                return false;
            drawUsers(userEvent);

        });

        //Validate Exits User
        function userExists(userEvents) {
            if (users_.length) {
                for (var i in users_) {
                    if (users_.hasOwnProperty(i)) {
                        var c = users_[i];
                        if (c.user_id == userEvents.user_id)
                            return true;
                    }
                }
            }
            return false;
        }

        //Print User
        function drawUsers(userEvents) {
            userEvents = userEvents || {};
            if (userEvents.drawed)
                return false;
            userEvents.drawed = true;

            var cTemplate = $(template),
                    index = users_.indexOf(userEvents);
            if (index == -1) {
                users_.push(userEvents);
            }

            cTemplate
                    .find('.TaskUser').text(userEvents.name).end()
                    .find('.TaskUser_user_id').val(userEvents.user_id).end();
            cTemplate
                    .find('.remove').on('click', function (e) {
                e.preventDefault();
                var idTask = $('#Taskmodal_taskmodal_id').val();
                if (idTask != "null")
                {
                    $.ajax({
                        url: "<?= Yii::app()->createUrl('site/removeusertask') ?>",
                        method: 'post',
                        dataType: 'json',
                        data: {
                            idTask: idTask,
                            userId: userEvents.user_id
                        },
                        success: function (response) {
                            cTemplate.remove();
                            users_.splice(users_.indexOf(userEvents), 1);
                        }
                    });
                } else {
                    cTemplate.remove();
                    users_.splice(users_.indexOf(userEvents), 1);
                }
            });
            $table.append(cTemplate);
        }

        function drawUsers_() {
            if (users_.length) {
                for (var i in users_) {
                    if (users_.hasOwnProperty(i)) {
                        drawUsers(users_[i]);
                    }
                }
                //Reset users_
                users_ = [];
            }
        }

        function loadUsersTask() {
            //Reset table
            $table.html('');
            if (users_.length == 0) {
                $.ajax({
                    url: "<?= Yii::app()->createUrl('site/usertask') ?>",
                    method: 'post',
                    dataType: 'json',
                    success: function (response) {
                        users_ = response.taskUser || [];
                        template = response.template || '';
                        drawUsers_();
                    }
                });
            } else {
                drawUsers_();
            }
        }

        function loadUsersTask_(id) {
            var idTask = id;
            //Reset table
            $table.html('');
            if (users_.length == 0) {
                $.ajax({
                    url: "<?= Yii::app()->createUrl('site/userstask') ?>",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        idTask: idTask
                    },
                    success: function (response) {
                        users_ = response.taskUser || [];
                        template = response.template || '';
                        drawUsers_();
                    }
                });
            } else {
                drawUsers_();
            }
        }

        //Call View Task
        $('.addTask').click(function () {
            loadUsersTask();
            //Call myModal with Structure Config
            $("#modal-task").modal({keyboard: false});
            $(".modal-dialog").width("90%");
            $("#Taskmodal_titlemodal").val("");
            $("#Taskmodal_start").val((new Date()).toISOString().slice(0, 10));
            $("#Taskmodal_end").val((new Date()).toISOString().slice(0, 10));
            $("#Taskmodal_startmm").val('00:00');
            $("#Taskmodal_endmm").val('00:00');
            $('#Taskmodal_allday').bootstrapToggle('on');
            $('#Taskmodal_email').bootstrapToggle('off');
            $('#Taskmodal_repeat').bootstrapToggle('off');
            $('#Taskmodal_task_visible').bootstrapToggle('on');
        });

        /////////////////////////////////////////////////////////////////
        //////////////////////////// REPORTS ///////////////////////////
        ///////////////////////////////////////////////////////////////
        $.ajax({
            url: "Sales/salesMonthlyIncrement",
            type: "get",
            success: function (data, textStatus) {
                $("#sales-increment").html(data);
            }
        });

        //View Purchases Modal
        $('#purchases_').click(function () {
            //Call myModal with Structure Config
            $("#modal-purchases").modal({keyboard: false});
            $(".modal-dialog").width("90%");
        });

        //View Sales Modal
        $('#sales_').click(function () {
            //Call myModal with Structure Config
            $("#modal-sales").modal({keyboard: false});
            $(".modal-dialog").width("90%");
        });

        //View User Modal
        $('#users_').click(function () {
            //Call myModal with Structure Config
            $("#modal-users").modal({keyboard: false});
            $(".modal-dialog").width("90%");
        });

        //View Reports Modal
        $('#reports_').click(function () {
            //Call myModal with Structure Config
            $("#modal-reports").modal({keyboard: false});
            $(".modal-dialog").width("90%");
        });

        //Send All Task
        $saveBtn.on('click', sendAll);

        //Edit Task
        $('.todo-list').on('click', '.fa-edit', function () {
            var id = $(this).attr('id');

            loadUsersTask_(id);
            //Call myModal with Structure Config
            $("#modal-task").modal({keyboard: false});
            $(".modal-dialog").width("90%");
            //Ajax Query Data
            $.ajax({
                url: '<?= Yii::app()->createUrl('site/loadTask') ?>',
                method: 'post',
                dataType: 'json',
                data: {
                    idTask: id,
                },
                success: function (response) {
                    var start = "", end = "", description = "", title = "", backgroundcolor = "", bordercolor = "", progress = 0;
                    $.each(response.alltask, function (i, item) {
                        $.each(item, function (io, items) {
                            //Switch Elements
                            switch (io) {
                                case 'task_progress' :
                                    progress = items;
                                    break;
                                case 'start' :
                                    start = items;
                                    break;
                                case 'end' :
                                    end = items;
                                    break;
                                case 'description' :
                                    description = items;
                                    break;
                                case 'title' :
                                    title = items;
                                    break;
                                case 'backgroundcolor' :
                                    backgroundcolor = items;
                                    break;
                                case 'bordercolor' :
                                    bordercolor = items;
                                    break;
                            }
                        })
                        $("#Taskmodal_taskmodal_id").val(id);
                        $("#Taskmodal_titlemodal").val(title);
                        $("#Taskmodal_start").val(start.substr(0, 10));
                        $("#Taskmodal_end").val(end.substr(0, 10));
                        $("#Taskmodal_description").val(description);
                        $("#Taskmodal_startmm").val(start.substr(11, 16));
                        $("#Taskmodal_endmm").val(end.substr(11, 16));
                        //Background
                        $("#Taskmodal_backgroundcolor_modal").val(backgroundcolor);
                        $("#Taskmodal_bordercolor_modal").val(bordercolor);
                        //Change Status
                        if (start.substr(11, 13) != "00")
                            $('#Taskmodal_allday').bootstrapToggle('off');
                        else
                            $('#Taskmodal_allday').bootstrapToggle('on');
                        $('#Taskmodal_email').bootstrapToggle('off');
                        $('#Taskmodal_repeat').bootstrapToggle('off');
                        $('#Taskmodal_task_visible').bootstrapToggle('on');
                        $("#task_progress_bar").css('width', progress + '%');
                        $("#Taskmodal_task_progress").val(progress);
                    })
                }
            });
        });

        //Delete Task
        $('.todo-list').on('click', '.fa-trash-o', function () {
            console.log($(this).attr('id'));
        });
    });
</script>