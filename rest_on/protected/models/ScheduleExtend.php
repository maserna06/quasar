<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;
use App\Utils\JsonResponse;

class ScheduleExtend extends Schedule {

    public static function saveEvent($start, $end, $id) {
        

        $purifier = Purifier::getInstance();
        $user = U::getInstance();

        //Validate ID in Event (Copy Event)
        if ($id != "null") {
            $model = Schedule::model()->findByPk($id);
            $model2 = (Notification::model()->find('schedule_id = ' . $id)) ? Notification::model()->find('schedule_id = ' . $id) : new Notification;
        } else {
            $model = new Schedule;
            $model2 = new Notification;
        }
        //Set Attributes
        $model->title = $_POST['Schedulemodal']['titlemodal'];
        $model->start = $start;
        $model->end = $end;
        $model->allday = (isset($_POST['Schedulemodal']['allday'])) ? ($_POST['Schedulemodal']['allday'] == "on") ? '1' : '0' : '0';
        $model->url = $_POST['Schedulemodal']['url'];
        $model->backgroundcolor = $_POST['Schedulemodal']['backgroundcolor'];
        $model->bordercolor = $_POST['Schedulemodal']['bordercolor'];
        $model->schedule_state = 1;
        //Validate null visibility (Copy Event)
        if ($id != "null")
            $model->schedule_visible = (isset($_POST['Schedulemodal']['schedulemodal_visible'])) ? ($_POST['Schedulemodal']['schedulemodal_visible'] == "on") ? '1' : '0' : '0';
        else
            $model->schedule_visible = 0;

        if ($model->save()) {
            //Return PK
            $pk = $model->getPrimaryKey();
            //Validate is_null (Copy Event)
            if ($id == "null") {
                $model1 = new ScheduleUser;
                $model1->schedule_id = $pk;
                $model1->user_id = $user->meId;
                $model1->role = 1;
                $model1->save();
            }
            //Notification Report
            $model2->schedule_id = $pk;
            $model2->notify_type = $_POST['Notification']['notify_type'];
            $model2->notify_time = $_POST['Notification']['notify_time'];
            $model2->notify_period = $_POST['Notification']['notify_period'];
            $model2->notify_state = 1;
            $model2->save();



            //Row Data
            foreach ($_POST['ScheduleUser']['user_id'] as $valor) {
                $model1 = new ScheduleUser;
                //Validate User Asign
                $model1->schedule_id = $pk;
                $model1->user_id = $valor;
                $model1->role = 3;
                if (!(ScheduleUser::model()->find('schedule_id = ' . $pk . ' and user_id =' . $valor))) //Validate no_exist (Copy Event)
                    $model1->save();
                //Send email
                $email = (isset($_POST['Schedulemodal']['email'])) ? ($_POST['Schedulemodal']['email'] == "on") ? '1' : '0' : '0';
                //Send Mail
                if ($email == '1') {
                    $user = User::model()->findByPk($model1->user_id);
                    if (isset($user->user_email)) {
                        $mail = new YiiMailer();
                        $mail->setView('schedule');
                        $mail->setData(array('model' => $model));
                        $mail->setLayout('mailer');
                        $mail->setFrom(Yii::app()->params['adminEmail']);
                        $mail->setTo(array('john.cubides87@gmail.com', $user->user_email));
                        $mail->setSubject('Evento : ' . $model->title);
                        $mail->send();
                    }
                }
            }
            return $pk;
        } else
            return null;

    }

}
