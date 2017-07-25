<?php

class TransfersController extends Controller {

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
                'actions' => array('index', 'create', 'update','viewproducts','detailview'),
                'roles' => array('super', 'admin', 'supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
        
        $model = $this->loadModel($id);
        $datos = TransfersExtend::datos();
        $datos = FinishedProductExtend::datos();
        $datos['transferConfig']->transfer_id = $model->transfer_consecut;
        $datos['products'] = TransfersExtend::transferProducts($id);
        

        $this->render('view', array(
            'model' => $model,
            'datos'=>$datos
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Transfers;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Transfers'])) {
            $model->attributes = $_POST['Transfers'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->transfer_id));
                Yii::app()->user->setFlash("success", "Transferenica realizada correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "Datos de Transferenica vacios; campos marcados con ( * ) son obligatorios.");
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

        if (isset($_POST['Transfers'])) {
            $model->attributes = $_POST['Transfers'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->transfer_id));
                Yii::app()->user->setFlash("success", "Transferencia actualizada correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "No es posible actualizar datos de Transferencia.");
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
        $model->transfer_status = 3;
        $model->save();
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

        $model = new Transfers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Transfers']))
            $model->attributes = $_GET['Transfers'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Transfers;
        $datos = TransfersExtend::datos();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Transfers'])) {
            //print_r($_POST);exit;
            $model = TransfersExtend::saveTransfer();
            $datosConf = array('estado' => 'success', 'mensaje' => 'Traslado # ' . $model->transfer_consecut . ' fue creada.');
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
            'datos'=>$datos
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Transfers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Transfers']))
            $model->attributes = $_GET['Transfers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Transfers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Transfers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Transfers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transfers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionViewProducts() {
        $model = TransfersExtend::viewProducts();
        $this->renderPartial('/products/viewModal', array('model' => $model), false, true);
    }
    
    public function actionDetailView() {
        $id = $_GET['id_detail'];
        $cant = $_GET['cantidad'];
        $product = TransfersDetails::model()->findByPk($id);

        $datos['name'] = $product->product->product_description;
        $datos['image'] = Yii::app()->theme->baseUrl . '/dist/img/' . $product->product->product_image;
        $datos['product_id'] = $product->product->product_id;
        $datos['wharehouse_id'] = $product->wharehouse_in;
        $datos['wharehouse_out'] = $product->wharehouse_out;
        $datos['quantity'] = $product->transfer_details_quantity;
        $datos['unit_id'] = $product->unit_id;
        $this->renderPartial('/products/productTransferUpdate', array('cant' => $cant, 'product' => $datos));
        exit;
    }

}
