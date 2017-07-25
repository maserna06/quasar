<?php

class PriceListController extends Controller
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
				'actions'=>array('admin','delete','create','update'),
				'roles'=>array('super','admin','supervisor'),
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

		$model=new PriceList;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['PriceList']))
		{
			$model->attributes=$_POST['PriceList'];
			if($model->save())
			{
				$this->redirect(array('view','id'=>$model->price_id));
				Yii::app()->user->setFlash("success","Lista de Precios creada correctamente.");
			}else
				Yii::app()->user->setFlash("danger","Datos de Lista de Precios vacios; campos marcados con ( * ) son obligatorios.");
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

		if(isset($_POST['PriceList']))
		{
			$model->attributes=$_POST['PriceList'];
			if($model->save())
			{
				$this->redirect(array('view','id'=>$model->price_id));
				Yii::app()->user->setFlash("success","Lista de Precios actualizada correctamente.");
			}else
				Yii::app()->user->setFlash("danger","No es posible actualizar datos de Lista de Precios.");
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

		//Delete PriceList
        if($list = PriceList::model()->findAll('price_id = '.$model->price_id))
             PriceList::model()->deleteAll('price_id = '.$model->price_id);
         
        $model->price_status = 3;
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

		$model=new PriceList('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PriceList']))
			$model->attributes=$_GET['PriceList'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if(Yii::app()->user->getId()===null)
            $this->redirect(array('site/login'));

		$model=new PriceList('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PriceList']))
			$model->attributes=$_GET['PriceList'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PriceList the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PriceList::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PriceList $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='price-list-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
