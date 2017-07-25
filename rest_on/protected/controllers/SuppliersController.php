<?php

use App\Utils\JsonResponse;
use App\Utils\Purifier;
use App\User\User as U;

class SuppliersController extends Controller{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column2';

  /**
   * @return array action filters
   */
  public function filters(){
    return array(
      'accessControl',// perform access control for CRUD operations
      'postOnly + delete',// we only allow deletion via POST request
      'postOnly + ajaxOnly + getSupplier',
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules(){
    return array(
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
          'actions' => array(
              'index',
              'view',
              'admin',
              'delete',
              'create',
              'update',
              'taxes',
              'getSupplier',
              'citiesbydepartament'
          ),
          'roles' => array('super', 'admin'),
      ),
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
          'actions' => array(
              'index',
              'view',
              'admin',
              'create',
              'update',
              'taxes',
              'getSupplier',
              'citiesbydepartament'
          ),
          'roles' => array('supervisor'),
      ),
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
          'actions' => array(
              'getSupplier',
              'citiesbydepartament'
          ),
          'roles' => array('vendor'),
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
  public function actionView($id){
    if(Yii::app()->user->getId() === null) $this->redirect(array('site/login'));

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
    //User Model
    $modelUser = User::model()->findByPk($id);
    if ($modelUser === null)
        $modelUser = new User;

    //Model Taxes
    $taxes = SuppliersExtend::taxesSupplier($id);

    $this->render('view',array(
      'model'=>$this->loadModel($id),
      'modelUser' => $modelUser,
      'taxes'=>$taxes,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate(){
    $purifier = Purifier::getInstance();
    $user = \App\User\User::getInstance();
    $model = new Suppliers;

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);

    if(isset($_POST['Suppliers'])){
      $attributes = $purifier->purify($_POST['Suppliers']);
      $model = Suppliers::model()->findByPk($attributes['supplier_nit']);
      if(!$model){
        $model = new Suppliers;
      }
      $model->attributes = $attributes;

      if(empty($model->bank_nit)) $model->bank_nit = NULL;

      if(empty($model->price_list_id)) $model->price_list_id = NULL;

      if($model->save()){
        if($user->isSupervisor){
          $companyCustomer = CompaniesSuppliers::getByNit($model->supplier_nit);
          if(!$companyCustomer){
            $cc = new CompaniesSuppliers();
            $cc->company_nit = $user->companyId;
            $cc->supplier_nit = $model->supplier_nit;
            if(!$cc->save()){
              $datosConf = array('estado' => 'danger', 'mensaje' => 'No se pudo asociar la empresa al proveedor debido a: '. CHtml::errorSummary($cc));
            }
          }
        }
        $datosConf = array('estado' => 'success', 'mensaje' => 'Proveedor creado correctamente.');
      }else
          $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Proveedor vacios; campos marcados con ( * ) son obligatorios.');

      print_r(json_encode($datosConf));
      exit;
    }

    $this->render('create',array(
      'model'=>$model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id){
    if(Yii::app()->user->getId() === null) $this->redirect(array('site/login'));

    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);

    if(isset($_POST['Suppliers'])){
      $model->attributes = $_POST['Suppliers'];

      if(empty($model->bank_nit)) $model->bank_nit = NULL;

      if(empty($model->price_list_id)) $model->price_list_id = NULL;

      if($model->save()){
        //$this->redirect(array('view','id'=>$model->supplier_nit));
        $datosConf = array('estado' => 'success', 'mensaje' => 'Proveedor actualizado correctamente.');
      }else
          $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Proveedor vacios; campos marcados con ( * ) son obligatorios.');

      print_r(json_encode($datosConf));
      exit;
    }

    $this->render('update',array(
      'model'=>$model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id){
    if(Yii::app()->user->getId() === null) $this->redirect(array('site/login'));

    $model = $this->loadModel($id);

    //Delete TaxesSupplier
    if($tax = TaxesSupplier::model()->findAll('supplier_nit = '.$model->supplier_nit))
        TaxesSupplier::model()->deleteAll('supplier_nit = '.$model->supplier_nit);

    $user = U::getInstance();
    if($user->isSuper){
      $model->supplier_status = 3;
      $model->save();
    }

    if($user->isSuper){
      //Internal: Remove all relation with companies and customers
      try{
        Yii::app()->db->createCommand()->delete(CompaniesSuppliers::model()->tableName(),[
          'AND',
          'supplier_nit=:supplier_nit'
          ],[
          ':supplier_nit'=>$model->supplier_nit
        ]);
      } catch(CDbException $e){
        
      }
    }else if($user->isOnlyAdmin()){
      //Internal: remove relation in tbl_companies_customers
      $csModel = CompaniesSuppliers::getByNit($model->supplier_nit);
      if($csModel){
        $csModel->delete();
      }
    }
    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if(!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
  }

  /**
   * Lists all models.
   */
  public function actionIndex(){
    if(Yii::app()->user->getId() === null) $this->redirect(array('site/login'));

    $model = new Suppliers('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['Suppliers'])) $model->attributes = $_GET['Suppliers'];

    $this->render('index',array(
      'model'=>$model,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin(){
    if(Yii::app()->user->getId() === null) $this->redirect(array('site/login'));

    $model = new Suppliers('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['Suppliers'])) $model->attributes = $_GET['Suppliers'];

    $this->render('admin',array(
      'model'=>$model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Suppliers the loaded model
   * @throws CHttpException
   */
  public function loadModel($id){
    $model = Suppliers::model()->findByPk($id);
    if($model === null)
        throw new CHttpException(404,'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Suppliers $model the model to be validated
   */
  protected function performAjaxValidation($model){
    if(isset($_POST['ajax']) && $_POST['ajax'] === 'suppliers-form'){
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionTaxes(){

    $id = $_GET['supplier'];
    $tax = SuppliersExtend::taxesSave();
    //Yii::app()->user->setFlash("info",$tax);

    $this->renderPartial('taxes',array(
      'model'=>$this->loadModel($id),
      'taxes'=>SuppliersExtend::taxesSupplier($id),
    ));
    Yii::app()->end();
  }

  public static function actionCitiesByDepartament() {
      $deparment_id = $_POST['Suppliers']['deparment_id'];
      $deparment_cod = Departaments::model()->find("deparment_id = ?",array($deparment_id));
      $citiesList = Cities::model()->findAll("city_state = ? AND deparment_cod = ?", array(1, $deparment_cod->deparment_cod));
      $citiesList = CHtml::listData($citiesList, 'city_id', 'city_name');
      foreach ($citiesList as $city_id => $city_name)
          echo CHtml::tag('option', array('value' => $city_id), CHtml::encode($city_name), true);
  }

  /**
   * Get Supplier data ajax via
   */
  public function actionGetSupplier(){
    $purifier = Purifier::getInstance();
    $response = JsonResponse::getInstance();
    $data = $purifier->purify(Yii::app()->request->getParam('data',[]));
    if($data){
      $model = Suppliers::model()->find('supplier_nit=:nit AND supplier_document_type=:type',[
        ':type'=>$data['document_type'],
        ':nit'=>$data['document_number'],
        ]
      );
      if($model){
        $companySupplier = CompaniesSuppliers::getByNit($data['document_number']);
        if($companySupplier){
          $response->error('Ya tiene registrado el proveedor '.$data['document_number'])
            ->output();
        }
        $attributes = $model->attributes;
        unset($attributes['supplier_nit'],$attributes['supplier_document_type']);
        $response->model = $attributes;
      }
    }

    $response->output();
  }

}
