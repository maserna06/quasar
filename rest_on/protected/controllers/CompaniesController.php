<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;
use App\Utils\JsonResponse;

class CompaniesController extends Controller {

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
    return [
        ['allow', // allow all users to perform 'index' and 'view' actions
            'actions' => [
                'index',
                'view',
                'admin',
                'delete',
                'create',
                'update',
                'citiesbydepartament',
                'assignprofile'
            ],
            'roles' => [Role::ROLE_SUPER],
        ],
        ['deny', // deny all users
            'users' => array('*'),
        ],
    ];
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id) {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));
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

    $users = CompaniesExtend::getUsersByCompany($id);

    $this->render('view', array(
        'model' => $this->loadModel($id),
        'users' => $users
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = new Companies;

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);

    if (isset($_POST['Companies'])) {
      $model = CompaniesExtend::newCompany();

      if (!$model->getErrors())
        $datosConf = array('estado' => 'success', 'mensaje' => 'Empresa creada con exito.');
      else
        $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Empresa vacios; campos marcados con ( * ) son obligatorios.');
      print_r(json_encode($datosConf));
      exit;
    }

    $this->render('create', array(
        'model' => $model,
    ));
  }

  /**
   * 	Assign Roles
   * */
  public function actionAssignProfile() {
    $purifier = Purifier::getInstance();
    $roleToAssign = $purifier->purify(Yii::app()->request->getParam('item'));
    $id = $purifier->purify(Yii::app()->request->getParam('id'));
    $response = JsonResponse::getInstance();
    $user = U::getInstance();
    try {
      if (!$user->isAdmin)
        throw new \CException('No tiene permisos para poder ejecutar esta acción!');
      if (!$user->isSuper && $roleToAssign == Role::ROLE_SUPER) {
        echo '_roles';
        exit;
        throw new \CException();
      } else {
        if (Role::isAssigned($roleToAssign, $id)) {
          if ($user->isSuper && $roleToAssign == Role::ROLE_SUPER && $user->me->id == $id) {
            throw new CException('You cannot revoke super role');
          }
          if (Role::revoke($roleToAssign, $id)) {
            if ($roleToAssign == Role::ROLE_VENDOR) {
              //Delete WharehousesUser
              if ($wharehouse = WharehousesUser::model()->findAll('user_id = ' . $id))
                WharehousesUser::model()->deleteAll('user_id = ' . $id);
            }
            $response->set('message', "success");
            if ($roleToAssign == Role::ROLE_VENDOR) {
              $response->set('hide', '.vendor-role-config');
            }
          } else
            throw new \CException('You cannot revoke this role');
        } else {
          if (Role::assign($roleToAssign, $id)) {
            $response->set('message', "success");
            if ($roleToAssign == Role::ROLE_VENDOR) {
              $response->set('show', '.btn.vendor-role-config');
            }
          } else
            throw new \CException();
        }
      }
    } catch (\CException $e) {
      $response->error(Yii::t('message', 'error'));
    }

    $response->output();
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

    if (isset($_POST['Companies'])) {

      $model = CompaniesExtend::newCompany($id);

      if (!$model->getErrors())
        $datosConf = array('estado' => 'success', 'mensaje' => 'Empresa actualizada con exito.');
      else
        $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Empresa vacios; campos marcados con ( * ) son obligatorios.');

      $model->attributes = $_POST['Companies'];

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

    //Logic Delete Products
    if ($productos = Products::model()->findAll('company_id = ' . $model->company_id))
      Products::model()->updateAll(array('product_status' => 3), 'company_id = ' . $model->company_id);
    //Logic Delete WhareHouses
    if ($bodegas = Wharehouses::model()->findAll('company_id = ' . $model->company_id)) {
      Wharehouses::model()->updateAll(array('wharehouse_status' => 3), 'company_id =' . $model->company_id);
      foreach ($bodegas as $bodega) {
        WharehousesExtend::deleteWharehouseUser($bodega->wharehouse_id);
      }
    }
    //Logic Delte Users
    if ($user = User::model()->findAll('company_id = ' . $model->company_id))
      User::model()->updateAll(array('user_status' => 3), 'company_id =' . $model->company_id);

    $model->company_status = 3;
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

    $model = new CompaniesExtend('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['CompaniesExtend']))
      $model->attributes = $_GET['CompaniesExtend'];

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

    $model = new CompaniesExtend('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['CompaniesExtend']))
      $model->attributes = $_GET['CompaniesExtend'];

    $this->render('admin', array(
        'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Companies the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = Companies::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Companies $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'companies-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public static function actionCitiesByDepartament() {
    $deparment_id = $_POST['Companies']['deparment_id'];
    $deparment_cod = Departaments::model()->find("deparment_id = ?", array($deparment_id));
    $citiesList = Cities::model()->findAll("city_state = ? AND deparment_cod = ?", array(1, $deparment_cod->deparment_cod));
    $citiesList = CHtml::listData($citiesList, 'city_id', 'city_name');
    foreach ($citiesList as $city_id => $city_name)
      echo CHtml::tag('option', array('value' => $city_id), CHtml::encode($city_name), true);
  }

}
