<?php

class PurchasesController extends Controller {

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
                'actions' => array('index', 'create', 'update', 'config', 'detailview'),
                'roles' => array('super', 'admin', 'supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
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
        $datos = PurchasesExtend::datos();
        $datos['facConfig']->purchase_id = $model->purchase_consecut;
        $datos['products'] = PurchasesExtend::productsPurchases($id);

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
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Purchases;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Purchases'])) {
            $model->attributes = $_POST['Purchases'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->purchase_id));
                Yii::app()->user->setFlash("success", "Compra creada correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "Datos de Compra vacios; campos marcados con ( * ) son obligatorios.");
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
        $datos = PurchasesExtend::datos();
        $datos['facConfig']->purchase_id = $model->purchase_consecut;
        $datos['products'] = PurchasesExtend::productsPurchases($id);

        if (isset($_POST['Purchases'])) {
            $model = PurchasesExtend::savePurchase($id);
            $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Compra # ' . $model->purchase_consecut . ' se ha actualizado.');
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
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = $this->loadModel($id);
        $model->purchase_status = 3;
        $model->save();
        $inventory = Inventories::model()->findAll('inventory_movement_type = "Purchases" and inventory_document_number = ' . $id);
        if ($inventory) {
            foreach ($inventory as $inv) {
                InventoriesExtend::deleteInventory($inv->product_id, $inv->inventory_stock);
            }
            Inventories::model()->updateAll(array('inventory_status' => 3), 'inventory_movement_type = "Purchases" and inventory_document_number = ' . $id);
        }
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

        $model = new Purchases;
        $datos = PurchasesExtend::datos();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Purchases'])) {
            $model = PurchasesExtend::savePurchase();
            if ($model->purchase_consecut) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Compra # ' . $model->purchase_consecut . ' fue creada.');
            } else {
                $datosConf = array('estado' => 'danger', 'mensaje' => 'No se completo el proceso');
            }
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
            'datos' => $datos,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndexes() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new PurchasesExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchasesExtend']))
            $model->attributes = $_GET['PurchasesExtend'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Config Section.
     */
    public function actionConfig() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));


        $id = OrderConfigExtend::ordenesCreate();
        if (!$id) {
            $model = new OrderConfig;
        } else {
            $model = OrderConfig::model()->findByPk($id);
            $model->scenario = 'existe'; //se decalra scenario para validar si se realiza cambio en el numero.
        }

        $id1 = OrderConfigExtend::comprasCreate();
        if (!$id1) {
            $model1 = new PurchaseConfig;
        } else {
            $model1 = PurchaseConfig::model()->findByPk($id1);
            $model1->scenario = 'existe';//se decalra scenario para validar si se realiza cambio en el numero.
        }

        $id2 = OrderConfigExtend::remisionesCreate();
        if (!$id2) {
            $model2 = new ReferralPConfig;
        } else {
            $model2 = ReferralPConfig::model()->findByPk($id2);
            $model2->scenario = 'existe';
        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $model1, $model2));

        if (isset($_POST['OrderConfig'])) {
            $model->attributes = $_POST['OrderConfig'];
            if ($model->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración de orden guardada con éxito.');
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


        if (isset($_POST['PurchaseConfig'])) {
            //print_r($_POST);exit;
            $model1->attributes = $_POST['PurchaseConfig'];
            $model1->purchase_payment = ($model1->purchase_payment == 'on') ? 1 : 0;
            if ($model1->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración para factura de compra guardada con éxito.');
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

        if (isset($_POST['ReferralPConfig'])) {
            $model2->attributes = $_POST['ReferralPConfig'];
            $model2->referralP_payment = ($model2->referralP_payment == 'on') ? 1 : 0;
            if ($model2->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración de remisión guardada con éxito.');
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

        $this->render('config', array(
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new PurchasesExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchasesExtend']))
            $model->attributes = $_GET['PurchasesExtend'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Purchases the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Purchases::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Purchases $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'purchases-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDetailView() {

        $id = $_GET['id_detail'];
        $cant = $_GET['cantidad'];
        $product = PurchaseDetails::model()->findByPk($id);
        if ($product->purchase_details_price == $product->product->product_price) {
            $tax = ProductsExtend::addProdTax($product->product_id);
        }
        if ($tax > 0)
            $tax = 1 + ($tax / 100);
        else
            $tax = 1;
        $this->renderPartial('/products/prodComprasUpdate', array('cant' => $cant, 'product' => $product, 'tax' => $tax));
        exit;
    }

}
