<?php

class TaxesController extends Controller {

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
                'actions' => array('admin', 'delete', 'create', 'update'),
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

        $model = new Taxes;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Taxes'])) {
            $model->attributes = $_POST['Taxes'];
            if ($_POST['mayor_valor'] == 'on') {
                $model->tax_ishighervalue = 1;
                $model->tax_islowervalue = 0;
            } else {
                $model->tax_ishighervalue = 0;
                $model->tax_islowervalue = 1;
            }

            if (empty($model->economic_activity_cod))
                $model->economic_activity_cod = NULL;

            if ($model->save())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Impuesto creado correctamente.');
            else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Impuesto vacios; campos marcados con ( * ) son obligatorios.');

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

        if (isset($_POST['Taxes'])) {
            $model->attributes = $_POST['Taxes'];
            if ($_POST['mayor_valor'] == 'on') {
                $model->tax_ishighervalue = 1;
                $model->tax_islowervalue = 0;
            } else {
                $model->tax_ishighervalue = 0;
                $model->tax_islowervalue = 1;
            }

            if (empty($model->economic_activity_cod))
                $model->economic_activity_cod = NULL;

            if ($model->save())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Impuesto actualizado correctamente.');
            else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Impuesto vacios; campos marcados con ( * ) son obligatorios.');

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

        //Delete TaxProduct
        if ($tax = TaxProduct::model()->findAll('tax_id = ' . $model->tax_id))
            TaxProduct::model()->deleteAll('tax_id = ' . $model->tax_id);

        //Delete TaxesCustomer
        if ($tax = TaxesCustomer::model()->findAll('tax_id = ' . $model->tax_id))
            TaxesCustomer::model()->deleteAll('tax_id = ' . $model->tax_id);

        //Delete TaxesSupplier
        if ($tax = TaxesSupplier::model()->findAll('tax_id = ' . $model->tax_id))
            TaxesSupplier::model()->deleteAll('tax_id = ' . $model->tax_id);

        $model->tax_status = 3;
        $model->save();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //echo "<pre>";print_r("STOP");echo "</pre>";
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Taxes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Taxes']))
            $model->attributes = $_GET['Taxes'];

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

        $model = new Taxes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Taxes']))
            $model->attributes = $_GET['Taxes'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Taxes the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Taxes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Taxes $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'taxes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
