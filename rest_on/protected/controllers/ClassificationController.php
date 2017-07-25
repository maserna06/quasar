<?php

class ClassificationController extends Controller {

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
            'actions' => array('index'),
            'users' => array('*'),
        ),
        array('allow', // allow admin user to perform 'admin' and 'delete' actions
            'actions' => array('admin', 'delete', 'create', 'update','wharehouse'),
            'roles' => array('super', 'admin', 'supervisor'),
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
//  public function actionView($id) {
//
//
//    if (Yii::app()->user->getId() === null)
//      $this->redirect(array('site/login'));
//
//    $this->render('view', array(
//        'model' => $this->loadModel($id),
//    ));
//  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = new Classification;

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);

    $classification = Yii::app()->request->getPost('Classification');
    if ($classification) {
      $products = Yii::app()->request->getPost('product');
      $wharehouses = Yii::app()->request->getPost('wharehouse');
      $model->attributes = $classification;
      if ($model->save()) {
        $classification_id = $model->classification_id;
        //Save Product
        if ($products) {
          foreach ($products as $product) {
            $modelCP = new ClassificationProduct;
            $modelCP->attributes = [
                'classification_id' => $classification_id,
                'product_id' => $product
            ];
            $modelCP->save();
          }
        }

        //Save Wharehouse
        if ($wharehouses) {
          foreach ($wharehouses as $wharehouse) {
            $modelCW = new WharehousesClassification;
            $modelCW->attributes = [
                'classification_id' => $classification_id,
                'wharehouse_id' => $wharehouse
            ];
            $modelCW->save();
          }
        }

        
        $datosConf = array('estado' => 'success', 'mensaje' => 'Clasificacion creada correctamente.');
      } else
        $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Clasificacion vacios; campos marcados con ( * ) son obligatorios.');

        print_r(json_encode($datosConf));
        exit;
    }

    $products = ClassificationExtend::getProducts();
    $wharehouses = ClassificationExtend::getWharehouses();
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/classifications.css');
    $this->render('create', array(
        'model' => $model, 'products' => $products, 'wharehouses' => $wharehouses
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

    $classification = Yii::app()->request->getPost('Classification');
    if ($classification) {
      $products = Yii::app()->request->getPost('product');
      $wharehouses = Yii::app()->request->getPost('wharehouse');
      $model->attributes = $classification;
      if ($model->save()) {
        $classification_id = $model->classification_id;
        $modelCP = new ClassificationProduct;
        $modelCP->deleteAllByAttributes(['classification_id' => $classification_id]);
        //Save Product
        if ($products) {
          foreach ($products as $product) {
            $modelCP = new ClassificationProduct;
            $modelCP->attributes = [
                'classification_id' => $classification_id,
                'product_id' => $product
            ];
            $modelCP->save();
          }
        }
        //Save Wharehouse
        $modelCW = new WharehousesClassification;
        $modelCW->deleteAllByAttributes(['classification_id' => $classification_id]);
        if ($wharehouses) {
          foreach ($wharehouses as $wharehouse) {
            $modelCW = new WharehousesClassification;
            $modelCW->attributes = [
                'classification_id' => $classification_id,
                'wharehouse_id' => $wharehouse
            ];
            $modelCW->save();
          }
        }
        $datosConf = array('estado' => 'success', 'mensaje' => 'Clasificacion creada correctamente.');
      } else
        $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Clasificacion vacios; campos marcados con ( * ) son obligatorios.');

        print_r(json_encode($datosConf));
        exit;
    }
    $products = ClassificationExtend::getProducts($id);
    $wharehouses = ClassificationExtend::getWharehouses($id);
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/classifications.css');
    $this->render('update', array(
        'model' => $model, 'products' => $products, 'wharehouses' => $wharehouses
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

    //Delete ClassificationProduct
    if ($classProduct = ClassificationProduct::model()->findAll('classification_id = ' . $model->classification_id))
      ClassificationProduct::model()->deleteAll('classification_id = ' . $model->classification_id);

    //Delete WharehousesClassification
    if ($classWharehouse = WharehousesClassification::model()->findAll('classification_id = ' . $model->classification_id))
      WharehousesClassification::model()->deleteAll('classification_id = ' . $model->classification_id);

    $model->classification_status = 3;
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

    $model = new Classification('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Classification']))
      $model->attributes = $_GET['Classification'];

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

    $model = new Classification('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Classification']))
      $model->attributes = $_GET['Classification'];

    $this->render('admin', array(
        'model' => $model,
    ));
  }
  
  /*
   * validar bodegas asigandas a clasificación
   */
  
  public function actionWharehouse($id){
      print_r($id);exit;
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Classification the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = Classification::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Classification $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'classification-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

}
