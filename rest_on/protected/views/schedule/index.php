<link rel="stylesheet" type="text/css" media="screen"
      href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
      <?php
      /* @var $this ScheduleController */

      use App\User\User as U;

$this->menu = array(
          array('label' => 'Calendario', 'url' => array('index')),
      );

      $user = U::getInstance();
      ?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'schedule-form',
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

<section class="content">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title">Eventos</h4>
                    </div>
                    <div class="box-body">
                        <div id="external-events">
                            <div class="checkbox">
                                <label for="drop-remove">
                                    <input type="checkbox" id="drop-remove">
                                    Remover luego de soltar
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear evento</h3>
                    </div>
                    <div class="box-body">
                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                            <ul class="fc-color-picker" id="color-chooser">
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
                        <div class="input-group">
                            <?php
                            echo $form->textField($model, 'title', array('class' => 'form-control', 'maxlength' => 300));
                            echo $form->hiddenField($model, 'schedule_visible', array('value' => '1'));
                            echo $form->hiddenField($model, 'schedule_state', array('value' => '1'));
                            echo $form->hiddenField($model, 'backgroundcolor', array('value' => 'rgb(60,141,188)'));
                            echo $form->hiddenField($model, 'bordercolor', array('value' => 'rgb(60,141,188)'));
                            ?>
                            <div class="input-group-btn">
                                <?php echo CHtml::button('Agregar', array('class' => 'btn btn-primary btn-flat', 'id' => 'add-new-event', 'onclick' => 'send();')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-9">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <!-- THE CALENDAR -->
                        <div id="calendarSchedule"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </div>


            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</section>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_modal'); ?>

<script>
    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
        ele.each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventFull = {
                title: $.trim($(this).text()), // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventFull);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1070,
                revert: true, // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
    }

    function visibleEvent(_id) {
        //visible Event ID
        $.ajax({
            url: '<?= Yii::app()->createUrl('schedule/isvisibleevent') ?>',
            method: 'post',
            dataType: 'json',
            data: {
                idEvent: _id,
            },
            success: function (response) {
                if (response.estado == 'success')
                    $('#Schedulemodal_schedule_visible').bootstrapToggle('on');
                else
                    $('#Schedulemodal_schedule_visible').bootstrapToggle('off');
            }
        });
    }

    function visibleEvents() {
        //Load All Events by User
        $.ajax({
            url: '<?= Yii::app()->createUrl('schedule/loadevents') ?>',
            method: 'post',
            dataType: 'json',
            success: function (response) {
                var idEvent = "", start = "", title = "", backgroundcolor = "", bordercolor = "";
                $.each(response.allevents, function (i, item) {
                    $.each(item, function (io, items) {
                        //Switch Elements
                        switch (io) {
                            case 'schedule_id' :
                                idEvent = items;
                                break;
                            case 'start' :
                                start = items;
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
                    //Create and validate events
                    if (start == null)
                        var event = $("<div id='" + idEvent + "' name='" + idEvent + "' />");
                    else
                        var event = $("<div id='null' name='" + idEvent + "' />");
                    //Attributes Event
                    event.css({"background-color": backgroundcolor, "border-color": bordercolor, "color": "#fff"}).addClass("external-event");
                    event.html(title);
                    $('#external-events').prepend(event);
                    //Add draggable funtionality
                    ini_events(event);
                })
            }
        });
    }

    function sendAll(form, hasError) {
        data = $("#schedulemodal-form").serialize();
        var formData = new FormData(document.getElementById("schedulemodal-form"));
        if (!hasError) {
            //Get value and make sure it is not null
            var val = $("#Schedulemodal_titlemodal").val();
            if (val.length == 0) {
                return;
            }

            //Load All Events by User
            $.ajax({
                url: '<?= Yii::app()->createUrl('schedule/addeventall') ?>',
                method: 'post',
                dataType: "html",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var datos = $.parseJSON(response);
                    if (datos['estado'] == 'success') {
                        var id = $.parseJSON(datos['mensaje']);
                        //Close Modal
                        $('#modal-create').modal('hide');
                        var title = $("#Schedulemodal_titlemodal").val();
                        var url = $("#Schedulemodal_url").val();
                        var start = '';
                        var end = '';
                        var repeat = $("#Schedulemodal_repeat").parent().hasClass('off');
                        var backgroundColor = $("#Schedulemodal_backgroundcolor_modal").val();
                        var borderColor = $("#Schedulemodal_bordercolor_modal").val();
                        //repeat
                        if (repeat == false) {
                            var fecha1 = new Date($("#Schedulemodal_start").val());
                            var fecha2 = new Date($("#Schedulemodal_end").val());
                            fecha1 = new Date(fecha1.setDate(fecha1.getDate() + 1));
                            fecha2 = new Date(fecha2.setDate(fecha2.getDate() + 1));
                            var idCreados = id;
                            var i = 0;
                            for (fecha1; fecha1 <= fecha2; fecha1 = new Date(fecha1.setDate(fecha1.getDate() + 1))) {
                                start = moment(fecha1).format("YYYY-MM-DD") + " " + $("#Schedulemodal_startmm").val().substr(0, 5);
                                end = moment(fecha1).format("YYYY-MM-DD") + " " + $("#Schedulemodal_endmm").val().substr(0, 5);
                                id = idCreados[i];
                                var eventFull = {
                                    //Start Params
                                    id: id,
                                    title: title,
                                    start: (start.substr(11, 2) != 00) ? start : start.substr(0, 10),
                                    end: (end.substr(11, 2) != 00) ? end : end.substr(0, 10),
                                    url: url,
                                    backgroundColor: backgroundColor,
                                    borderColor: borderColor
                                };
                                $('#calendarSchedule').fullCalendar('removeEvents', 'null');
                                $('#calendarSchedule').fullCalendar('removeEvents', id);
                                $('#calendarSchedule').fullCalendar('renderEvent', eventFull, true);
                                document.getElementById("schedulemodal-form").reset();
                                //$('#' + id).attr('id', 'null');
                                id = id + 1;
                                i = i + 1;
                            }
                        } else {
                            start = $("#Schedulemodal_start").val() + " " + $("#Schedulemodal_startmm").val().substr(0, 5);
                            end = $("#Schedulemodal_end").val() + " " + $("#Schedulemodal_endmm").val().substr(0, 5);
                            id = id[0];
                            var eventFull = {
                                //Start Params
                                id: id,
                                title: title,
                                start: (start.substr(11, 2) != 00) ? start : start.substr(0, 10),
                                end: (end.substr(11, 2) != 00) ? end : end.substr(0, 10),
                                url: url,
                                backgroundColor: backgroundColor,
                                borderColor: borderColor
                            };
                            $('#calendarSchedule').fullCalendar('removeEvents', 'null');
                            $('#calendarSchedule').fullCalendar('removeEvents', id);
                            $('#calendarSchedule').fullCalendar('renderEvent', eventFull, true);
                            document.getElementById("schedulemodal-form").reset();
                            //$('#' + id).attr('id', 'null');
                        }
                    }
                }
            });

        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }

    function deleteAll() {
        var id = $('#Schedulemodal_schedulemodal_id').val();
        if (id != 'null') {
            var formData = {"id": id};

            $.ajax({
                url: '<?= Yii::app()->createUrl('schedule/deleteEvent') ?>',
                type: 'post',
                data: formData,
                success: function () {

                    $('#calendarSchedule').fullCalendar('removeEvents', id);
                }
            });
            $('#calendarSchedule').fullCalendar('removeEvents', 'null');
            $('#modal-create').modal('hide');
        }

    }
    function send(form, hasError) {
        data = $("#schedule-form").serialize();
        var formData = new FormData(document.getElementById("schedule-form"));

        if (!hasError) {
            //Get value and make sure it is not null
            var val = $("#Schedule_title").val();
            if (val.length == 0) {
                return;
            }

            //Load All Events by User
            $.ajax({
                url: '<?= Yii::app()->createUrl('schedule/addevent') ?>',
                method: 'post',
                dataType: "html",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var datos = $.parseJSON(response);
                    if (datos['estado'] == 'success') {
                        //Create events
                        var event = $("<div id='" + datos['mensaje'] + "' name='" + datos['mensaje'] + "' />");
                        event.css({"background-color": $('#Schedule_backgroundcolor').val(), "border-color": $('#Schedule_bordercolor').val(), "color": "#fff"}).addClass("external-event");
                        event.html(val);
                        $('#external-events').prepend(event);
                        //Add draggable funtionality
                        ini_events(event);
                        document.getElementById("schedule-form").reset();
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
                $saveBtn = $('#saveUser'),
                $delete = $('#delete-event'),
                users_ = [],
                template = null,
                currentUserSelected = null;

        //Task Visible
        visibleEvents();

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
                    .find('.ScheduleUser').text(userEvents.name).end()
                    .find('.ScheduleUser_user_id').val(userEvents.user_id).end();
            cTemplate
                    .find('.remove').on('click', function (e) {
                e.preventDefault();
                var idEvent = $('#Schedulemodal_schedulemodal_id').val();
                if (idEvent != "null")
                {
                    $.ajax({
                        url: "<?= Yii::app()->createUrl('schedule/removeuserevents') ?>",
                        method: 'post',
                        dataType: 'json',
                        data: {
                            idEvent: idEvent,
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
            $('#modal-create').modal({
                keyboard: false,
                backdrop: false
            });
            $(".modal-dialog").width("80%");
        }

        function loadUsersEvents(id) {
            var idEvent = id;
            //Reset table
            $table.html('');
            if (users_.length == 0) {
                $.ajax({
                    url: "<?= Yii::app()->createUrl('schedule/userevents') ?>",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        idEvent: idEvent
                    },
                    success: function (response) {
                        users_ = response.eventsUser || [];
                        template = response.template || '';
                        drawUsers_();
                    }
                });
            } else {
                drawUsers_();
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////// START CALENDAR //////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        var calendar = $('#calendarSchedule');
        calendar.fullCalendar({
            lang: 'es',
            timezone: 'America/Bogota',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'dia'
            },
            //Random default events
            events:
                    {
                        url: '<?= Yii::app()->createUrl('schedule/loadallevents') ?>',
                        type: 'POST'
                    },
            selectable: true,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped
                //Var This (tthis)
                var tthis = $(this);
                //Call Load Table
                loadUsersEvents(tthis.attr('id'));
                // retrieve the dropped element's stored Event Object
                var originalEventObject = tthis.data('eventObject');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.id = tthis.attr('id');
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                copiedEventObject.backgroundColor = tthis.css("background-color");
                copiedEventObject.borderColor = tthis.css("border-color");
                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                calendar.fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $.ajax({
                        url: "<?= Yii::app()->createUrl('schedule/visibleevents') ?>",
                        method: 'post',
                        dataType: 'json',
                        data: {
                            idEvent: tthis.attr('name')
                        },
                        success: function (response) {
                            tthis.remove();
                        }
                    });
                }
                //Activate Model
                $('#modal-create').modal('show');
                //Start Params
                $("#Schedulemodal_schedulemodal_id").val(tthis.attr('id'));
                $("#Schedulemodal_titlemodal").val(copiedEventObject.title);
                $("#Schedulemodal_start").val((new Date(date)).toISOString().slice(0, 10));
                $("#Schedulemodal_end").val((new Date(date)).toISOString().slice(0, 10));
                $("#Schedulemodal_startmm").val((new Date(date)).toISOString().slice(11, 16));
                $("#Schedulemodal_endmm").val((new Date(date)).toISOString().slice(11, 16));
                //Change Status
                $('#Schedulemodal_allday').bootstrapToggle('on');
                $('#Schedulemodal_email').bootstrapToggle('off');
                $('#Schedulemodal_repeat').bootstrapToggle('off');
                $('#Schedulemodal_schedule_visible').bootstrapToggle('on');
                //Background
                $("#Schedulemodal_backgroundcolor_modal").val(tthis.css("background-color"));
                $("#Schedulemodal_bordercolor_modal").val(tthis.css("background-color"));
            },
            eventClick: function (event, element) {
                $(".modal-dialog").width("80%");
                //Activate Model
                $('#modal-create').modal('show');
                //Load Users
                loadUsersEvents(event.id);
                //Visible Event
                visibleEvent(event.id);
                //Start Params
                $("#Schedulemodal_schedulemodal_id").val(event.id);
                $("#Schedulemodal_titlemodal").val(event.title);
                $("#Schedulemodal_start").val((event.start == null) ? "" : (new Date(event.start['_d'])).toISOString().slice(0, 10));
                $("#Schedulemodal_end").val((event.end == null) ? (new Date(event.start['_d'])).toISOString().slice(0, 10) : (new Date(event.end['_d'])).toISOString().slice(0, 10));
                $("#Schedulemodal_startmm").val((event.start == null) ? "00:00" : (new Date(event.start['_d'])).toISOString().slice(11, 16));
                $("#Schedulemodal_endmm").val((event.end == null) ? "00:00" : (new Date(event.end['_d'])).toISOString().slice(11, 16));
                $("#Schedulemodal_url").val(event.url);
                //Change Status
                if (new Date(event.start['_d']).toISOString().slice(11, 13) != "00")
                    $('#Schedulemodal_allday').bootstrapToggle('off');
                else
                    $('#Schedulemodal_allday').bootstrapToggle('on');
                //Background
                $("#Schedulemodal_backgroundcolor_modal").val(event.backgroundColor);
                $("#Schedulemodal_bordercolor_modal").val(event.borderColor);
                $('#Schedulemodal_repeat').bootstrapToggle('off');
            },
            eventDrop: function (event, delta, revertFunc) {
                //Create Event Array
                var eventFull = {
                    //Start Params
                    id: event.id,
                    start: (event.start == null) ? "" : new Date(event.start['_d']).toISOString().slice(0, 16),
                    end: (event.end == null) ? "" : new Date(event.end['_d']).toISOString().slice(0, 16)
                };
                //Send Post
                $.ajax({
                    url: "<?= Yii::app()->createUrl('schedule/updatefastevent') ?>",
                    method: 'post',
                    dataType: 'json',
                    data: eventFull
                });
            },
            eventResize: function (event, delta, revertFunc) {
                //Create Event Array
                var eventFull = {
                    //Start Params
                    id: event.id,
                    start: (event.start == null) ? "" : new Date(event.start['_d']).toISOString().slice(0, 16),
                    end: (event.end == null) ? "" : new Date(event.end['_d']).toISOString().slice(0, 16)
                };
                //Send Post
                $.ajax({
                    url: "<?= Yii::app()->createUrl('schedule/updatefastevent') ?>",
                    method: 'post',
                    dataType: 'json',
                    data: eventFull
                });
            }
        });

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default

        //Color Chooser
        $("#color-chooser > li > a").click(function (e) {
            e.preventDefault();
            //Save color
            currColor = $(this).css("color");
            //Add color effect to button
            $('#Schedule_backgroundcolor').val(currColor);
            $('#Schedule_bordercolor').val(currColor);
            $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        });

        //Send All Event
        $saveBtn.on('click', sendAll);
        $delete.on('click', deleteAll)
    });
</script>