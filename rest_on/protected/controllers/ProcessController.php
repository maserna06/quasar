<?php

class ProcessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','create','update'),
				'roles'=>array('super','admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if(Yii::app()->user->getId()===null)
            $this->redirect(array('site/login'));

		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(Yii::app()->user->getId()===null)
            $this->redirect(array('site/login'));
        
		$model=new Process;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Process']))
		{
			$model->attributes=$_POST['Process'];
			if($model->save())
				$datosConf = array('estado' => 'success', 'mensaje' => 'Proceso creado correctamente.');
			else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Proceso vacios; campos marcados con ( * ) son obligatorios.');

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
	public function actionUpdate($id)
	{
		if(Yii::app()->user->getId()===null)
            $this->redirect(array('site/login'));

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Process']))
		{
			$model->attributes=$_POST['Departaments'];
			if($model->save())
				$datosConf = array('estado' => 'success', 'mensaje' => 'Departamento actualizado correctamente.');
			else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Departamento vacios; campos marcados con ( * ) son obligatorios.');
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
	public function actionDelete($id)
	{
		if(Yii::app()->user->getId()===null)
            $this->redirect(array('site/login'));

		$model = $this->loadModel($id);
        $model->process_status = 3;
        $model->save();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->getId()===null)
            $this->redirect(array('site/login'));

		$model = new Process('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Process']))
            $model->attributes = $_GET['Process'];
        
        $this->render('index', array(
            'model' => $model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Process the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Process::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Process $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='process-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
