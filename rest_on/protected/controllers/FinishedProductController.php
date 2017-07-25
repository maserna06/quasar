<?php

class FinishedProductController extends Controller {

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
                'actions' => array('indexes', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'admin', 'delete', 'create', 'update', 'ViewProducts', 'DetailView'),
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
        $model = $this->loadModel($id);
        $datos = FinishedProductExtend::datos();
        $datos['finishConfig']->finished_product_id = $model->finished_product_consecut;
        $datos['products'] = FinishedProductExtend::finishedProducts($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $this->render('view', array(
            'model' => $model,
            'datos' => $datos,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        
        $this->redirect(array('index'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {


        $model = $this->loadModel($id);
        $datos = FinishedProductExtend::datos();
        $datos['finishConfig']->finished_product_id = $model->finished_product_consecut;
        $datos['products'] = FinishedProductExtend::finishedProducts($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['FinishedProduct'])) {
            $model = FinishedProductExtend::saveFinishedProduct($id);
            $datosConf = array('estado' => 'success', 'mensaje' => 'Producto Terminado # ' . $model->finished_product_consecut . ' se ha actualizado.');
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('update', 'id' => $id));
        }

        $this->render('update', array(
            'model' => $model,
            'datos' => $datos,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

     /**
     * Lists all models.
     */
    public function actionIndexes() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new FinishedProduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FinishedProduct']))
            $model->attributes = $_GET['FinishedProduct'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new FinishedProduct;
        $datos = FinishedProductExtend::datos();

        if (isset($_POST['FinishedProduct'])) {
            $model = FinishedProductExtend::saveFinishedProduct();
            if ($model->finished_product_consecut) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Movimiento Producto Terminado #' . $model->finished_product_consecut . ' a sido creado correctamente');
                Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            }
            $this->redirect(array('index'));
            echo '<pre>';
            print_r($_POST);
            exit;
        }

        $this->render('create', array(
            'model' => $model,
            'datos' => $datos,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new FinishedProduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FinishedProduct']))
            $model->attributes = $_GET['FinishedProduct'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionViewProducts() {
        $model = FinishedProductExtend::viewProducts();
        $this->renderPartial('/products/viewModal', array('model' => $model), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return FinishedProduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = FinishedProduct::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param FinishedProduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'finished-product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDetailView() {
        $id = $_GET['id_detail'];
        $cant = $_GET['cantidad'];
        $product = FinishedProductDetails::model()->findByPk($id);
//        echo'<pre>';
//        print_r($product);exit;
        $components = NULL;
        $components = FinishedProductDetailsComponent::model()->findAllByAttributes(array('finished_product_details_id' => $id));
        if ($components) {
            $datosCom = array();
            $i = 0;
            foreach ($components as $comp) {
                $datosCom[$i]['product_id'] = $comp->product_id;
                $datosCom[$i]['name'] = $comp->product->product_description;
                $datosCom[$i]['unit_id'] = $comp->unit_id;
                $datosCom[$i]['quantity'] = $comp->quantity;
                $i++;
            }
            $components = json_encode($datosCom);
        }
        $datos['name'] = $product->product->product_description;
        $datos['image'] = Yii::app()->theme->baseUrl . '/dist/img/' . $product->product->product_image;
        $datos['product_id'] = $product->product->product_id;
        $datos['wharehouse_id'] = $product->wharehouse_inserted;
        $datos['quantity'] = $product->finished_product_details_quantity;
        $datos['unit_id'] = $product->unit_id;
        $this->renderPartial('/products/productFinishUpdate', array('cant' => $cant, 'product' => $datos, 'components' => $components));
        exit;
    }

}
