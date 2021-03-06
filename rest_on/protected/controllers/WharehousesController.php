<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;
use App\Utils\JsonResponse;

class WharehousesController extends Controller {

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
        array('allow', // allow all users to perform 'index' and 'view' actions
            'actions' => array('index', 'view'),
            'users' => array('*'),
        ),
        array('allow', // allow admin user to perform 'admin' and 'delete' actions
            'actions' => array('admin', 'delete', 'create', 'update', 'citiesbydepartament', 'removeuser', 'getUsers', 'RelationshipUserWharehouse','modalConfig', 'saveVendorOptions'),
            'roles' => array('super', 'admin'),
        ),
        array('deny', // deny all users
            'users' => array('*'),
        ),
    );
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id) {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));
    $baseUrl = Yii::app()->baseUrl;
    $cs = Yii::app()->getClientScript();
    $cs->registerCssFile('http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');    
    $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/wharehouses.js');

    $format = Yii::app()->request->getParam('format');

    if ($format) {
        switch ($format) {
            case 'pdf':
                error_reporting(0);
                $content = '<img style="width:100%;" src="' . $_POST['image'] . '" />';

                $html2pdf = new HTML2PDF('P', [215.9, 279.4], 'es');
                $html2pdf->WriteHTML($content);
                $html2pdf->Output($model->product_description . '.pdf');
                Yii::app()->end();
                break;
        }
    }

    $this->render('view', array(
        'model' => $this->loadModel($id), 'users' => WharehousesExtend::getUsersByWharehouses($id)
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = new Wharehouses;

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);
    if (isset($_POST['Wharehouses'])) {
      $purifier = Purifier::getInstance();
      $user = U::getInstance();
      $attributes = $purifier->purify($_POST['Wharehouses']);
      if ($user->isOnlyAdmin()) {
        $attributes['company_id'] = $user->companyId;
      }
      $model->attributes = $attributes;
      if($model->save())
        $datosConf = array('estado' => 'success', 'mensaje' => 'Bodega creada correctamente.');
      else
          $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Bodega vacios; campos marcados con ( * ) son obligatorios.');
      
      print_r(json_encode($datosConf));
      exit;
    }

    $this->render('create', array(
        'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id) {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);

    if (isset($_POST['Wharehouses'])) {
      $purifier = Purifier::getInstance();
      $user = U::getInstance();
      $attributes = $purifier->purify($_POST['Wharehouses']);
      if ($user->isOnlyAdmin()) {
        $attributes['company_id'] = $user->companyId;
      }
      $model->attributes = $attributes;
      if($model->save())
        $datosConf = array('estado' => 'success', 'mensaje' => 'Bodega actualizada correctamente.');
      else
          $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Bodega vacios; campos marcados con ( * ) son obligatorios.');
      
      print_r(json_encode($datosConf));
      exit;
    }

    $this->render('update', array(
        'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id) {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = $this->loadModel($id);
    WharehousesExtend::deleteWharehouseUser($id);
    $model->wharehouse_status = 3;
    $model->save();
    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * Lists all models.
   */
  public function actionIndex() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = new Wharehouses('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Wharehouses']))
      $model->attributes = $_GET['Wharehouses'];

    $this->render('index', array(
        'model' => $model,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = new Wharehouses('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Wharehouses']))
      $model->attributes = $_GET['Wharehouses'];

    $this->render('admin', array(
        'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Wharehouses the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = Wharehouses::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Wharehouses $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'wharehouses-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public static function actionCitiesByDepartament() {
    $deparment_id = $_POST['Wharehouses']['deparment_id'];
    $deparment_cod = Departaments::model()->find("deparment_id = ?", array($deparment_id));
    $citiesList = Cities::model()->findAll("city_state = ? AND deparment_cod = ?", array(1, $deparment_cod->deparment_cod));
    $citiesList = CHtml::listData($citiesList, 'city_id', 'city_name');
    foreach ($citiesList as $city_id => $city_name)
      echo CHtml::tag('option', array('value' => $city_id), CHtml::encode($city_name), true);
  }

  /**
   * remove user relationship with wharehouse
   * @param int $id
   * @throws \CException
   */
  public function actionRemoveuser($id) {
    $purifier = Purifier::getInstance();
    $response = JsonResponse::getInstance();
    $userRemove = $purifier->purify(Yii::app()->request->getParam('item'));
    $user = U::getInstance();
    try {
      if (!$user->isAdmin) {
        throw new \CException('No tiene permisos para poder ejecutar esta acción!');
      }
      if (WharehousesExtend::getUserByWharehouse($id, $userRemove)) {
        $data = array('user_id' => $userRemove, 'wharehouse_id' => $id);
        if (WharehousesUser::model()->deleteAllByAttributes($data)) {
          $response->set('success', $id);
        }
      }
    } catch (\CException $e) {
      $response->error(Yii::t('errors', $e->getMessage() ?: 'You cannot set this action'));
    }
    $response->output();
  }

  /**
   * return data json users to wharehouse
   * @param int $id
   * @throws \CException
   */
  public function actionGetUsers($id) {
    $purifier = Purifier::getInstance();
    $response = JsonResponse::getInstance();
    $term = $userRemove = $purifier->purify(Yii::app()->request->getParam('term'));
    $user = U::getInstance();
    try {
      if (!$user->isAdmin) {
        throw new \CException('No tiene permisos para poder ejecutar esta acción!');
      }
      if ($dataUsers = WharehousesExtend::getUserTypeWharehouse($id, $term, Role::ROLE_VENDOR)) {

        $dateReturn = [];
        foreach ($dataUsers as $user) {
          $dataReturn[] = [
              'id' => $user['user_id'],
              'label' => $user['user_firtsname'] . ' ' . $user['user_lastname'],
              'value' => $user['user_firtsname'] . ' ' . $user['user_lastname'],
              'linkAjax' => Yii::app()->createUrl('wharehouses/RelationshipUserWharehouse/' . $id)
          ];
        }
        echo CJSON::encode($dataReturn);
      }
    } catch (\CException $e) {
      $response->error(Yii::t('errors', $e->getMessage() ?: 'You cannot set this action'));
    }
    Yii::app()->end();
  }

  public function actionRelationshipUserWharehouse($id) {
    $purifier = Purifier::getInstance();
    $response = JsonResponse::getInstance();
    $userRequest = $userRemove = $purifier->purify(Yii::app()->request->getParam('user'));
    $user = U::getInstance();
    try {
      if (!$user->isAdmin) {
        throw new \CException('No tiene permisos para poder ejecutar esta acción!');
      }
      //Status Save
      $stateSave = 0;
      $multicash = 0;
      //Query Exist Data
      $WhUser = WharehousesUser::model()->find(array('condition'=>'wharehouse_id=:wharehouse_id','params'=>array(':wharehouse_id'=>$purifier->purify($id))));

      if($WhUser){
        //Attributes of model WhareHouse User
        $att = array('user_id' => $purifier->purify($userRequest), 'wharehouse_id' => $purifier->purify($id), 'multicash' => $WhUser->multicash, 'daily_close' => $WhUser->daily_close, 'date_open' => $WhUser->date_open, 'date_close' => $WhUser->date_close, 'cash_ip' => $WhUser->cash_ip, 'cash_port' => $WhUser->cash_port, 'dataphone_ip' => $WhUser->dataphone_ip, 'dataphone_port' => $WhUser->dataphone_port, 'dataphone_name' => $WhUser->dataphone_name);
        //Validate MultiCash
        if($WhUser->multicash == 1){$stateSave = 1; $multicash = 1;}
      }else{
        //Attributes of model WhareHouse User
        $att = array('user_id' => $purifier->purify($userRequest), 'wharehouse_id' => $purifier->purify($id), 'multicash' => 0, 'daily_close' => 1, 'date_open' => '2100-01-01', 'date_close' => '1900-01-01', 'cash_ip' => 0, 'cash_port' => 0, 'dataphone_ip' => 0, 'dataphone_port' => 0, 'dataphone_name' => 0);
        //Enable MultiCash
        $stateSave = 1;
        $multicash = 0;
      }

      $WharehousesUsers = new WharehousesUser;
      $WharehousesUsers->attributes = $att;
      if ($WharehousesUsers->save()) {
        $userData = User::model()->findByPk($userRequest);
        $response->set('data', [
            'user_id'=>$userData['user_id'],
            'user_name'=>$userData['user_name'],
            'user_firtsname'=>$userData['user_firtsname'],
            'user_lastname'=>$userData['user_lastname'],
            'user_status'=>$userData['user_status'],
            'link'=> CHtml::link("On", array("wharehouses/removeuser", "id" => $id, "item" => $userData['user_id']), array("class" => "btn btn-success pull-right")),
            'multicash'=>$multicash,
            'openModal'=>$stateSave,
        ]);
      }
    } catch (\CException $e) {
      $response->error(Yii::t('errors', $e->getMessage() ?: 'You cannot set this action'));
    }
    $response->output();
  }  
  
  public function actionSaveVendorOptions() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));
    $purifier = Purifier::getInstance();
    $response = JsonResponse::getInstance();    
    $user = U::getInstance();

    //Data POST Send
    $wharehouse_id = $purifier->purify($_POST['WharehousesUser']['wharehouse_id']);
    $user_id = $purifier->purify($_POST['WharehousesUser']['user_id']);
    $multicash = (isset($_POST['WharehousesUser']['multicash'])) ? 1 : 0;
    $daily_close = (isset($_POST['WharehousesUser']['daily_close'])) ? 1 : 0;
    $cash_ip = (isset($_POST['WharehousesUser']['cash_ip'])) ? $_POST['WharehousesUser']['cash_ip'] : 0;
    $cash_port = (isset($_POST['WharehousesUser']['cash_port'])) ? $_POST['WharehousesUser']['cash_port'] : 0;
    $dataphone_ip = (isset($_POST['WharehousesUser']['dataphone_ip'])) ? $_POST['WharehousesUser']['dataphone_ip'] : 0;
    $dataphone_port = (isset($_POST['WharehousesUser']['dataphone_port'])) ? $_POST['WharehousesUser']['dataphone_port'] : 0;
    $dataphone_name = (isset($_POST['WharehousesUser']['dataphone_name'])) ? $_POST['WharehousesUser']['dataphone_name'] : 0;

    //Load Dates
    $WharehousesUser = WharehousesUser::model()->find(array('condition'=>'wharehouse_id=:wharehouse_id and user_id=:user_id','params'=>array(':wharehouse_id'=>$wharehouse_id, ':user_id'=>$user_id))); 

    //Attributes of model WhareHouse User
    $att = array(
      'multicash' => $multicash, 
      'daily_close' => $daily_close,
      'date_open' => $WharehousesUser->date_open, 
      'date_close' => $WharehousesUser->date_close,
      'cash_ip' => $cash_ip , 
      'cash_port' => $cash_port, 
      'dataphone_ip' => $dataphone_ip, 
      'dataphone_port' => $dataphone_port,
      'dataphone_name' => $dataphone_name,
      'user_id' => $user_id,
      'wharehouse_id' => $wharehouse_id
    );

    //First Update MultiCash State
    WharehousesUser::model()->updateAll(array('multicash' => $multicash), 'wharehouse_id = '+$wharehouse_id);

    //Second Delete
    $data = array('user_id' => $user_id, 'wharehouse_id' => $wharehouse_id);
    WharehousesUser::model()->deleteAllByAttributes($data);
    
    //Third Save Information  
    $model = new WharehousesUser;
    $model->attributes = $att;

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);
    
    //Validate Save
    if($model->save()){
      $userData = User::model()->findByPk($user_id);
      $datosConf = array('estado' => 'success', 'mensaje' => 'Vendedor configurado con exito.', 'multicash' => $multicash, 'user_id' => $user_id, 'user_name'=>$userData['user_name'], 'user_firtsname'=>$userData['user_firtsname'], 'user_lastname'=>$userData['user_lastname'], 'user_status'=>$userData['user_status'], 'link'=> CHtml::link("On", array("wharehouses/removeuser", "id" => $wharehouse_id, "item" => $userData['user_id']), array("class" => "btn btn-success pull-right")));
    }
    else{
      echo $model->getErrors();
      $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de configuración vacios; campos marcados con ( * ) son obligatorios.');
    }
    //Return Data
    print_r(json_encode($datosConf));
    exit;
  }

}
