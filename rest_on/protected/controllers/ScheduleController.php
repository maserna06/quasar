<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;
use App\Utils\JsonResponse;

class ScheduleController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' actions
                'actions' => array(
                    'index',
                    'addevent',
                    'addeventall',
                    'autocomplete',
                    'visibleevents',
                    'isvisibleevent',
                    'userevents',
                    'removeuserevents',
                    'updatefastevent',
                    'loadallevents',
                    'loadevents',
                    'deleteEvent',
                ),
                'roles' => array(
                    'super',
                    'admin',
                    'supervisor',
                    'vendor',
                    'contable'
                ),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Schedule the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Schedule::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Schedule $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        //echo 'si cae';exit;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'schedule-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionIndex() {
        $purifier = Purifier::getInstance();
        $model = new Schedule;

        //Register Script
        $cs = Yii::app()->clientScript;
        $cssCoreUrl = $cs->getCoreScriptUrl();
        $cs->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');
        $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/fullcalendar/fullcalendar.min.js', $cs::POS_END);
        $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/fullcalendar/locale/es.js', $cs::POS_END);
        $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/datepicker/bootstrap-timepicker.js');
        $cs->registerScriptFile('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
        $cs->registerCssFile(Yii::app()->theme->baseUrl . '/plugins/datepicker/timepicker.less');
        $cs->registerCssFile(Yii::app()->theme->baseUrl . '/plugins/fullcalendar/fullcalendar.min.css');
        $cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/schedule.css');
        $cs->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css');

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionAddEventAll() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));


        if (isset($_POST['Schedulemodal'])) {
            $id = $_POST['Schedulemodal']['schedulemodal_id'];
            
            $inicio = new DateTime($_POST['Schedulemodal']['start']);
            $fin = new DateTime($_POST['Schedulemodal']['end']);
            $repeat = (isset($_POST['Schedulemodal']['repeat'])) ? ($_POST['Schedulemodal']['repeat'] == "on") ? '1' : '0' : '0';
            $idsCreados = array();
            if ($repeat == 1) {
                $dias = $inicio->diff($fin);
                $dias = $dias->days;
                if ($id != "null") {
                    $start = $_POST['Schedulemodal']['start'] . " " . $_POST['Schedulemodal']['startmm'];
                    $end = $_POST['Schedulemodal']['start'] . " " . $_POST['Schedulemodal']['endmm'];
                    $idsCreados[] = ScheduleExtend::saveEvent($start, $end, $id);
                    $nexDate = $inicio->add(new DateInterval('P1D'));
                } else
                    $nexDate = $inicio;
                
                for ($nexDate; $nexDate <= $fin; $nexDate = $nexDate->add(new DateInterval('P1D'))) {
                    $start = $nexDate->format('Y-m-d') . " " . $_POST['Schedulemodal']['startmm'];
                    $end = $nexDate->format('Y-m-d') . " " . $_POST['Schedulemodal']['endmm'];
                    $idsCreados[] = ScheduleExtend::saveEvent($start, $end, 'null');
                }
            } else {
                $start = $_POST['Schedulemodal']['start'] . " " . $_POST['Schedulemodal']['startmm'];
                $end = $_POST['Schedulemodal']['end'] . " " . $_POST['Schedulemodal']['endmm'];
                $idsCreados[] = ScheduleExtend::saveEvent($start, $end, $id);
            }
            $idsCreados = json_encode($idsCreados);
            $datosConf = array('estado' => 'success', 'mensaje' => $idsCreados);
            print_r(json_encode($datosConf));
            exit;
        }
    }

    public function actionAddEvent() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $purifier = Purifier::getInstance();
        $user = U::getInstance();

        $model = new Schedule;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['Schedule'])) {
            $model->attributes = $_POST['Schedule'];
            if ($model->save()) {
                $pk = $model->getPrimaryKey();
                $model1 = new ScheduleUser;
                $model1->schedule_id = $pk;
                $model1->user_id = $user->meId;
                $model1->role = 1;
                if ($model1->save())
                    $datosConf = array('estado' => 'success', 'mensaje' => $pk);
                else
                    $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Evento vacios; campos marcados con ( * ) son obligatorios.');
            } else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Evento vacios; campos marcados con ( * ) son obligatorios.');
            print_r(json_encode($datosConf));
            exit;
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }
    
    public function actionDeleteEvent(){
        
        $id = $_POST['id'];
        $model = Schedule::model()->findByPk($id);
        $model->schedule_state = 3;
        $model->save();
        
        print_r($model);exit;
        
    }

    public function actionAutocomplete() {
        $purifier = Purifier::getInstance();
        $user = U::getInstance();

        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            $term = strtoupper($term);
            $query = Yii::app()->db->createCommand();
            $query->select([
                        'user_id',
                        'CONCAT ( user_firtsname, " ", user_lastname) AS user_name',
                    ])->from('tbl_user')
                    ->andWhere('user_firtsname LIKE :name', [':name' => '%' . $term . '%'])
                    ->orWhere('user_lastname LIKE :name', [':name' => '%' . $term . '%'])
                    ->andWhere('user_status = 1');
            if (!$user->isSuper) {
                $query->andWhere('company_id=:company_id', [':company_id' => $user->companyId]);
            }
            $res = $query->queryAll();
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }

    public function actionVisibleEvents() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) $_POST['idEvent'];
        $model = Schedule::model()->findByPk($id);
        $model->schedule_visible = '0';

        if ($model->save())
            $datosConf = array('estado' => 'success', 'mensaje' => $model->getPrimaryKey());
        else
            $datosConf = array('estado' => 'danger', 'mensaje' => 'No es posible eliminar evento.');

        print_r(json_encode($datosConf));
        exit;
    }

    public function actionIsVisibleEvent() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) $_POST['idEvent'];
        $model = Schedule::model()->findByPk($id);

        if ($model->schedule_visible == '1')
            $datosConf = array('estado' => 'success', 'mensaje' => 'Evento visible.');
        else
            $datosConf = array('estado' => 'danger', 'mensaje' => 'Evento no visible.');

        print_r(json_encode($datosConf));
        exit;
    }

    public function actionUpdateFastEvent() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        //Post Attributes
        $id = (int) $_POST['id'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        //Instance Schedule
        $model = Schedule::model()->findByPk($id);
        $model->start = $start;
        if ($end == "")
            $model->end = $start;
        else
            $model->end = $end;

        if ($model->save())
            $datosConf = array('estado' => 'success', 'mensaje' => $model->getPrimaryKey());
        else
            $datosConf = array('estado' => 'danger', 'mensaje' => 'No es posible actualizar evento.');

        print_r(json_encode($datosConf));
        exit;
    }

    public function actionUserEvents() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) $_POST['idEvent'];
        $query = Yii::app()->db->createCommand();
        $query->select([
                    'u.user_id',
                    'CONCAT ( u.user_firtsname, " ", u.user_lastname) AS name',
                ])
                ->from('tbl_user u')
                ->leftJoin('tbl_schedule_user sc', 'sc.user_id = u.user_id')
                ->andWhere('sc.schedule_id = :id', [':id' => $id]);

        $eventsUser = $query->queryAll();
        $template = '
      <tr>
        <td>
          <div class="ScheduleUser"></div>
          <input type="hidden" name="ScheduleUser[user_id][]" class="ScheduleUser_user_id" />
        </td>
        <td align="center">
          <a href="#" class="remove"><i class="fa fa-times"></i></a>
        </td>
      </tr>
    ';
        $response->set('eventsUser', $eventsUser)
                ->set('template', $template)
                ->output();
    }

    public function actionRemoveUserEvents() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) $_POST['idEvent'];
        $user_id = $_POST['userId'];

        //Delete Row
        if (ScheduleUser::model()->deleteAll('schedule_id = ' . $id . ' and user_id = ' . $user_id))
            $datosConf = array('estado' => 'success', 'mensaje' => 'Usuario desasignado con exito.');
        else
            $datosConf = array('estado' => 'danger', 'mensaje' => 'El usuario no se desasigno.');

        print_r(json_encode($datosConf));
        exit;
    }

    public function actionLoadEvents() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $query = Yii::app()->db->createCommand();
        $query->select(['s.schedule_id', 's.title', 's.start', 's.end', 's.allday', 's.url', 's.backgroundcolor', 's.bordercolor'])
                ->from('tbl_schedule s')
                ->join('tbl_schedule_user su', 's.schedule_id = su.schedule_id')
                ->where('su.user_id = ' . $user->meId)
                ->andWhere('s.schedule_visible = 1')
                ->andWhere('s.schedule_state = 1');

        $allevents = $query->queryAll();

        $response->set('allevents', $allevents)
                ->output();
    }

    public function actionLoadAllEvents() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $post_data = array();

        $query = Yii::app()->db->createCommand();
        $query->select(['s.schedule_id', 's.title', 's.start', 's.end', 's.allday', 's.url', 's.backgroundcolor', 's.bordercolor'])
                ->from('tbl_schedule s')
                ->join('tbl_schedule_user su', 's.schedule_id = su.schedule_id')
                ->where('su.user_id = ' . $user->meId)
                ->andWhere('s.start != "null"')
                ->andWhere('s.schedule_state = 1');

        $allevents = $query->queryAll();

        //Row Data
        foreach ($allevents as $i => $val) {
            foreach ($val as $key => $value) {
                switch ($key) {
                    case 'schedule_id' : $eventArray['id'] = $value;
                        break;
                    case 'title' : $eventArray['title'] = $value;
                        break;
                    case 'start' : $eventArray['start'] = (substr($value, 11, 2) != 00) ? substr($value, 0, 16) : substr($value, 0, 10);
                        break;
                    case 'end' : $eventArray['end'] = (substr($value, 11, 2) != 00) ? substr($value, 0, 16) : substr($value, 0, 10);
                        break;
                    case 'allday' : $eventArray['allday'] = ($value == 1) ? true : false;
                        break;
                    case 'url' : $eventArray['url'] = ($value == null) ? '' : $value;
                        break;
                    case 'backgroundcolor' : $eventArray['backgroundColor'] = $value;
                        break;
                    case 'bordercolor' : $eventArray['borderColor'] = $value;
                        break;
                }
            }
            $post_data[$i] = $eventArray;
        }

        //Print json
        echo json_encode($post_data);
    }

}
