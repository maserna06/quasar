<?php

use App\Utils\JsonResponse;
use App\Utils\Purifier;
use App\User\User as U;

class CustomersController extends Controller {

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
            'postOnly + ajaxOnly + getCustomer', // we only allow deletion via POST request
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
                    'taxes',
                    'getCustomer',
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
                    'getCustomer',
                    'citiesbydepartament'
                ),
                'roles' => array('supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'fastcustomers',
                    'getCustomer',
                    'citiesbydepartament',
                    'customerbycompany'
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
        $taxes = CustomersExtend::taxesCustom($id);

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'modelUser' => $modelUser,
            'taxes' => $taxes,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $purifier = Purifier::getInstance();
        $user = \App\User\User::getInstance();
        $model = new Customers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Customers'])) {
            $attributes = $purifier->purify($_POST['Customers']);
            $model = Customers::model()->findByPk($attributes['customer_nit']);
            if (!$model) {
                $model = new Customers;
            }
            $model->attributes = $attributes;

            if (empty($model->bank_nit)) {
                $model->bank_nit = NULL;
            }

            if (empty($model->price_list_id)) {
                $model->price_list_id = NULL;
            }

            if ($model->save()) {
                if ($user->isSupervisor) {
                    $companyCustomer = CompaniesCustomers::getByNit($model->customer_nit);
                    if (!$companyCustomer) {
                        $cc = new CompaniesCustomers;
                        $cc->company_nit = $user->companyId;
                        $cc->customer_nit = $model->customer_nit;
                        if (!$cc->save()) {
                            //Yii::app()->user->setFlash('warning', 'No se pudo asociar la empresa al cliente debido a:' . CHtml::errorSummary($cc));
                $datosConf = array('estado' => 'danger', 'mensaje' => 'No se pudo asociar la empresa al cliente debido a: '. CHtml::errorSummary($cc));
                        }
                    }
                }
                //$this->redirect(array('view', 'id' => $model->customer_nit));
                $datosConf = array('estado' => 'success', 'mensaje' => 'Cliente creado correctamente.');
            } else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Cliente vacios; campos marcados con ( * ) son obligatorios.');

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

        if (isset($_POST['Customers'])) {
            $model->attributes = $_POST['Customers'];

            if (empty($model->bank_nit)) {
                $model->bank_nit = NULL;
            }

            if (empty($model->price_list_id)) {
                $model->price_list_id = NULL;
            }

            if ($model->save()) {
                //$this->redirect(array('view', 'id' => $model->customer_nit));
                $datosConf = array('estado' => 'success', 'mensaje' => 'Cliente actualizado correctamente.');
            } else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Cliente vacios; campos marcados con ( * ) son obligatorios.');

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

        //Delete TaxesCustomer
        if ($tax = TaxesCustomer::model()->findAll('customer_nit = ' . $model->customer_nit))
            TaxesCustomer::model()->deleteAll('customer_nit = ' . $model->customer_nit);
        if (U::getInstance()->isSuper) {
            $model->customer_status = 3;
            $model->save();
        }
        $user = U::getInstance();
        if ($user->isSuper) {
            //Internal: Remove all relation with companies and customers
            try {
                Yii::app()->db->createCommand()->delete(CompaniesCustomers::model()->tableName(), [
                    'AND',
                    'customer_nit=:customer_nit'
                        ], [
                    ':customer_nit' => $model->customer_nit
                ]);
            } catch (CDbException $e) {
                
            }
        } else if ($user->isOnlyAdmin()) {
            //Internal: remove relation in tbl_companies_customers
            $ccModel = CompaniesCustomers::getByNit($model->customer_nit);
            if ($ccModel) {
                $ccModel->delete();
            }
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Customers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customers']))
            $model->attributes = $_GET['Customers'];

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

        $model = new Customers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customers']))
            $model->attributes = $_GET['Customers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Customers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Customers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Customers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionTaxes() {

        $id = $_GET['customer'];
        $tax = CustomersExtend::taxesSave();
        //Yii::app()->user->setFlash("info",$tax);

        $this->renderPartial('taxes', array(
            'model' => $this->loadModel($id),
            'taxes' => CustomersExtend::taxesCustom($id),
        ));
        Yii::app()->end();
    }

    /**
     * Get customer data ajax via
     */
    public function actionGetCustomer() {
        $purifier = Purifier::getInstance();
        $response = JsonResponse::getInstance();
        $data = $purifier->purify(Yii::app()->request->getParam('data', []));
        if ($data) {
            $model = Customers::model()->find('customer_nit=:nit AND customer_document_type=:type', [
                ':type' => $data['document_type'],
                ':nit' => $data['document_number'],
                    ]
            );
            if ($model) {
                $companyCustomer = CompaniesCustomers::getByNit($data['document_number']);
                if ($companyCustomer) {
                    $response->error('Ya tiene registrado el cliente ' . $data['document_number'])
                            ->output();
                }
                $attributes = $model->attributes;
                unset($attributes['customer_nit'], $attributes['customer_document_type']);
                $response->model = $attributes;
            }
        }

        $response->output();
    }

    public static function actionCitiesByDepartament() {
        $deparment_id = $_POST['Customers']['deparment_id'];
        $deparment_cod = Departaments::model()->find("deparment_id = ?", array($deparment_id));
        $citiesList = Cities::model()->findAll("city_state = ? AND deparment_cod = ?", array(1, $deparment_cod->deparment_cod));
        $citiesList = CHtml::listData($citiesList, 'city_id', 'city_name');
        foreach ($citiesList as $city_id => $city_name)
            echo CHtml::tag('option', array('value' => $city_id), CHtml::encode($city_name), true);
    }

    public function actionFastCustomers() {
        $purifier = Purifier::getInstance();
        $user = \App\User\User::getInstance();
        $model = new Customers;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        $departament = NULL;
        $city = NUll;
        $userLogged = U::getInstance();
        $wharehouses = WharehousesUser::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
        foreach ($wharehouses as $data){
            if($data->wharehouses->company_id = $userLogged->companyId){
                    $departament = $data->wharehouses->deparment_id;
                    $city = $data->wharehouses->city_id;
                    break;
            }
        }

        if (isset($_POST['Customers'])) {
            $attributes = $purifier->purify($_POST['Customers']);
            $model = new Customers;
            $model->attributes = $attributes;

            if (empty($model->bank_nit)) {
                $model->bank_nit = NULL;
            }

            if (empty($model->price_list_id)) {
                $model->price_list_id = NULL;
            }
            if ($model->save()) {
                $companyCustomer = CompaniesCustomers::getByNit($model->customer_nit);
                if (!$companyCustomer) {
                    $cc = new CompaniesCustomers;
                    $cc->company_nit = $user->companyId;
                    $cc->customer_nit = $model->customer_nit;
                    if (!$cc->save()) {
                        Yii::app()->user->setFlash('warning', 'No se pudo asociar la empresa al cliente debido a:' . CHtml::errorSummary($cc));
                    }
                }
                echo $model->customer_nit;
                exit;
                //Yii::app()->user->setFlash("success", "Cliente creado correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "Datos de Cliente vacios; campos marcados con ( * ) son obligatorios.");
        }
        $this->renderPartial('fastCustomer', array(
            'model' => $model,
            'city'=>$city,
            'departament'=>$departament,
                ), false, true);
    }

    public static function actionCustomerByCompany() {
        $datos = CustomersExtend::customerCompany();
        foreach ($datos as $id => $name)
            echo CHtml::tag('option', array('value' => $id), CHtml::encode($name), true);
        exit;
    }

}
