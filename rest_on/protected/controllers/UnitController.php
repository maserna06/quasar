<?php

use App\Utils\JsonResponse;
use App\Utils\Purifier;
use App\User\User as U;

class UnitController extends Controller {

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'index',
                    'view',
                    'admin',
                    'delete',
                    'create',
                    'update',
                    'unitrelations',
                ),
                'roles' => array('super', 'admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'index',
                    'view',
                    'admin',
                    'create',
                    'update'
                ),
                'roles' => array('supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'unitrelations',
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

        $model = new Unit;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Unit'])) {
            $model->attributes = $_POST['Unit'];
            if($model->save())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Unidad de Medida creada correctamente.');
            else
              $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Unidad de Medida vacios; campos marcados con ( * ) son obligatorios.');
            
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

        if (isset($_POST['Unit'])) {
            $model->attributes = $_POST['Unit'];
            if($model->save())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Unidad de Medida actualizada correctamente.');
            else
              $datosConf = array('estado' => 'danger', 'Datos de Unidad de Medida vacios; campos marcados con ( * ) son obligatorios.');
            
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

        //Logic Delete ConvertionUnit
        if ($convertion = ConversionUnit::model()->findAll('convertion_base_unit = ' . $model->unit_id))
            ConversionUnit::model()->updateAll(array('convertion_status' => 3), 'convertion_base_unit = ' . $model->unit_id);

        //Logic Delete ConvertionUnit
        if ($convertion = ConversionUnit::model()->findAll('convertion_destination_unit = ' . $model->unit_id))
            ConversionUnit::model()->updateAll(array('convertion_status' => 3), 'convertion_destination_unit = ' . $model->unit_id);

        //Delete Components
        if ($component = Components::model()->findAll('unit_id = ' . $model->unit_id))
            Components::model()->deleteAll('unit_id = ' . $model->unit_id);

        $model->unit_status = 3;
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

        $model = new Unit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Unit']))
            $model->attributes = $_GET['Unit'];

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

        $model = new Unit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Unit']))
            $model->attributes = $_GET['Unit'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Unit the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Unit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Unit $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'unit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUnitRelations() {

        $datos = UnitExtend::selectConversion($_GET['unit_id']);
        foreach ($datos as $id => $name)
            echo CHtml::tag('option', array('value' => $id), CHtml::encode($name), true);
        exit;
    }

}
