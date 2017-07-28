<?php

use App\Utils\Purifier;
//use App\Utils\JsonResponse;
use App\User\User as U;

class InventoriesController extends Controller {

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column2';

  /**
   * inventory-view
   */
  const INVENTORY_COOKIE_VIEW = 'inventory-view';

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
            'actions' => array('index', 'view', 'getSearch', 'getProductDetail'),
            'users' => array('*'),
        ),
        array('allow', // allow admin user to perform 'admin' and 'delete' actions
            'actions' => array('admin', 'delete', 'create', 'config', 'update'),
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
  public function actionView($id) {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $this->render('view', array(
        'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = new Inventories;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['Inventories'])) {
      $model->attributes = $_POST['Inventories'];
      if ($model->save()) {
        $this->redirect(array('view', 'id' => $model->inventory_id));
        Yii::app()->user->setFlash("success", "Inventories creado correctamente.");
      } else
        Yii::app()->user->setFlash("danger", "Datos de Inventories vacios; campos marcados con ( * ) son obligatorios.");
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
    // $this->performAjaxValidation($model);

    if (isset($_POST['Inventories'])) {
      $model->attributes = $_POST['Inventories'];
      if ($model->save()) {
        $this->redirect(array('view', 'id' => $model->inventory_id));
        Yii::app()->user->setFlash("success", "Inventories actualizado correctamente.");
      } else
        Yii::app()->user->setFlash("danger", "No es posible actualizar datos de Inventories.");
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

    $this->loadModel($id)->delete();

    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * Lists all models.
   */
  public function actionIndex() {
    if (Yii::app()->user->getId() === null) {
      if (Yii::app()->request->isAjaxRequest) {
        Yii::app()->end('403');
      }
      $this->redirect(array('site/login'));
    }

    $userId = Yii::app()->user->id;

    $limit = (int) Yii::app()->request->getParam('limit', 12);
    $offset = (int) Yii::app()->request->getParam('page', 0);
    $product = (int) Yii::app()->request->getParam('product', false);
    $query = (string) Yii::app()->request->getParam('query', false);
    $view = (string) Yii::app()->request->getParam('view', false);
    $company = (string) Yii::app()->request->getParam('company', false);

    if (!isset(Yii::app()->request->cookies[self::INVENTORY_COOKIE_VIEW . '-' . $userId]) || !empty($view)) {
      self::setInventoryView($view);
    }

    $viewValue = Yii::app()->request->cookies[self::INVENTORY_COOKIE_VIEW . '-' . $userId]->value;
    switch ($viewValue) {
      case '12':
        $render = '_data_12';
        $limit = 18;
        break;
      case '222222':
        $render = '_data_222222';
        $limit = 18;
        break;
      default:
        $render = '_data';
        break;
    }

    $products = InventoriesExtend::getProducts($limit, $offset - 1, $query, $product, $company);


    if (Yii::app()->request->isAjaxRequest) {
      $json['data'] = $this->renderPartial($render, array('products' => $products['data']), true);
      $json['paginator'] = $products['paginator'];
      echo CJSON::encode($json);
      Yii::app()->end();
    } else {
      $user = U::getInstance();
      $companies = false;
      if ($user->isSuper) {
        $companies = Companies::model()->findAll();
      }

      $cs = Yii::app()->getClientScript();
      $cs->registerCssFile('http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
      $cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/inventories.css');
      $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/inventories.js');
      $this->render('index', array(
          'model' => $products, 'view' => $viewValue, 'render' => $render, 'companies' => $companies
      ));
    }
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    if (Yii::app()->user->getId() === null)
      $this->redirect(array('site/login'));

    $model = new Inventories('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Inventories']))
      $model->attributes = $_GET['Inventories'];

    $this->render('admin', array(
        'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Inventories the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = Inventories::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Inventories $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'inventories-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Find data about a product in JSON 
   * @throws \CException
   */
  public static function actionGetSearch() {
    $purifier = Purifier::getInstance();
    $term = $purifier->purify(Yii::app()->request->getParam('term'));
    if ($data = InventoriesExtend::getProductsByTerm($term)) {

      $dateReturn = [];
      foreach ($data as $item) {
        $dataReturn[] = [
            'id' => $item['product_id'],
            'label' => $item['product_description'],
            'value' => $item['product_description']
        ];
      }
      echo CJSON::encode($dataReturn);
    }
    Yii::app()->end();
  }

  /**
   * return data info about product
   * return json
   */
  public function actionGetProductDetail() {
    $purifier = Purifier::getInstance();
    $product = $purifier->purify(Yii::app()->request->getParam('product'));
    $json['error'] = true;
    if ($product) {
      $productData = InventoriesExtend::getProductById($product);
      $stock = InventoriesExtend::getStockByWharehouse($product);
      $json['data'] = $this->renderPartial('_product_detail_tabs', ['product' => $productData, 'stock' => $stock], true);
      $json['error'] = false;
    }

    echo CJSON::encode($json);

    Yii::app()->end();
  }

  /**
   * Save view state
   * @param string $view
   */
  protected function setInventoryView($view) {
    $cookie = new \CHttpCookie(self::INVENTORY_COOKIE_VIEW . '-' . Yii::app()->user->id, $view);
    $cookie->expire = time() + 3600 * 24 * 365;
    \Yii::app()->request->cookies[self::INVENTORY_COOKIE_VIEW . '-' . Yii::app()->user->id] = $cookie;
  }

  /**
     * Config Section.
     */
    public function actionConfig() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        //echo "<pre>";print_r($_POST);echo "</pre>";exit;


        $id = TransferConfigExtend::transfersCreate();
        if (!$id) {
            $model = new TransferConfig;
        } else {
            $model = TransferConfig::model()->findByPk($id);
            $model->scenario = 'existe'; //se decalra scenario para validar si se realiza cambio en el numero.
        }

        $id1 = FinishedProductConfigExtend::finishedproductCreate();
        if (!$id1) {
            $model1 = new FinishedProductConfig;
        } else {
            $model1 = FinishedProductConfig::model()->findByPk($id1);
            $model1->scenario = 'existe';//se decalra scenario para validar si se realiza cambio en el numero.
        }
        //Miguel p 27-07-2017
        $id2 = FinishedInventoryConfigExtend::finishedinventoryCreate();
        /*if (!$id2) {
            $model2 = new InventoryConfig;
        } else {
            $model2 = InventoryConfig::model()->findByPk($id1);
            $model2->scenario = 'existe';//se decalra scenario para validar si se realiza cambio en el numero.
        }*/

       
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $model1, $model2));

        if (isset($_POST['TransferConfig'])) {
            $model->attributes = $_POST['TransferConfig'];
            if ($model->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración de traslado guardada con éxito.');
            } else {
                $error = $model->errors;
                $key_error = array_keys($error);
                $msj = '';
                foreach ($key_error as $key) {
                    $errores = $error[$key];
                    foreach ($errores as $value) {
                        $msj.= "$key = " . $value . "<br>";
                    }
                }
                $datosConf = array('estado' => 'danger', 'mensaje' => 'No se completo el proceso.<br>'.$msj);
            }
            print_r(json_encode($datosConf));
            exit;
        }


        if (isset($_POST['FinishedProductConfig'])) {
            //print_r($_POST);exit;
            $model1->attributes = $_POST['FinishedProductConfig'];
            if ($model1->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración para producto terminado guardada con éxito.');
            } else {
                $error = $model1->errors;
                $key_error = array_keys($error);
                $msj = '';
                foreach ($key_error as $key) {
                    $errores = $error[$key];
                    foreach ($errores as $value) {
                        $msj.= "$key = " . $value . "<br>";
                    }
                }
                $datosConf = array('estado' => 'danger', 'mensaje' => 'No se completo el proceso.<br>'.$msj);
            }
            print_r(json_encode($datosConf));
            exit;
        }

        /*miguel p 27-07-2017*/

        if (isset($_POST['FinishedInventoryConfig'])) {
            //print_r($_POST);exit;
            $model2->attributes = $_POST['FinishedInventoryConfig'];
            if ($model2->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración para Inventario guardada con éxito.');
            } else {
                $error = $model2->errors;
                $key_error = array_keys($error);
                $msj = '';
                foreach ($key_error as $key) {
                    $errores = $error[$key];
                    foreach ($errores as $value) {
                        $msj.= "$key = " . $value . "<br>";
                    }
                }
                $datosConf = array('estado' => 'danger', 'mensaje' => 'No se completo el proceso de inventario.<br>'.$msj);
            }
            print_r(json_encode($datosConf));
            exit;
        }


        $this->render('config', array(
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,
        ));
    }

}
