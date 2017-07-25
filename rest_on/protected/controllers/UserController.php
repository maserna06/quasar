<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;
use App\Utils\JsonResponse;

class UserController extends Controller {

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
            'postOnly + ajaxOnly + assignprofile', // we only allow deletion via POST request
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
                'actions' => array('index', 'NewRegister', 'RecoveryPassword', 'ChangePassword', 'citiesbydepartament', 'citiesbydepartaments'),
                'users' => array('*'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view', 'viewprofile', 'DataUser', 'DataCustomer', 'DataSupplier'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'create', 'update', 'assign', 'assignprofile', 'exportpdf', 'bodegas', 'citiesbydepartament'),
                'roles' => Role::getAdmins(),
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

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'bodegas' => UserExtend::bodegasUser($id),
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewProfile() {
        $id = Yii::app()->user->id;
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = $this->loadModel($id);
        $model->scenario = 'updatepass';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            //print_r($_POST);
            $model->old_password = $_POST['User']['old_password'];
            $model->user_passwordhash = md5($_POST['User']['new_password']);
            $model->new_password = md5($_POST['User']['new_password']);
            $model->repeat_password = md5($_POST['User']['repeat_password']);
            if (!$model->save())
                print_r($model->errors);
            $this->setMessages(true, $model->getErrors());
            $this->redirect('viewprofile', array(
                'model' => $model,
            ));
        }


        $this->render('viewprofile', array(
            'model' => $model,
        ));
    }

    /**
     * 	Assign Roles
     * */
    public function actionAssignProfile($id) {
        $purifier = Purifier::getInstance();
        $roleToAssign = $purifier->purify(Yii::app()->request->getParam('item'));
        $response = JsonResponse::getInstance();

        $user = U::getInstance();
        try {
            if (!$user->isAdmin) {
                throw new \CException('No tiene permisos para poder ejecutar esta acción!');
            }
            if (!$user->isSuper && $roleToAssign == Role::ROLE_SUPER) {
                echo '_roles';
                exit;
                throw new \CException();
            } else {
                if (Role::isAssigned($roleToAssign, $id)) {
                    if ($user->isSuper && $roleToAssign == Role::ROLE_SUPER && $user->me->id == $id) {
                        throw new CException('You cannot revoke super role');
                    }
                    if (Role::revoke($roleToAssign, $id)) {
                        if ($roleToAssign == Role::ROLE_VENDOR) {
                            //Delete WharehousesUser
                            if ($wharehouse = WharehousesUser::model()->findAll('user_id = ' . $id))
                                WharehousesUser::model()->deleteAll('user_id = ' . $id);
                        }
                        $response->set('success', time());
                        if ($roleToAssign == Role::ROLE_VENDOR) {
                            $response->set('hide', '.vendor-role-config');
                        }
                    } else {
                        throw new \CException('You cannot revoke this role');
                    }
                } else {
                    if (Role::assign($roleToAssign, $id)) {
                        $response->set('success', time());
                        if ($roleToAssign == Role::ROLE_VENDOR) {
                            $response->set('show', '.btn.vendor-role-config');
                        }
                    } else {
                        throw new \CException();
                    }
                }
            }
        } catch (\CException $e) {
            $response->error(Yii::t('errors', $e->getMessage() ?: 'You cannot set this role'));
        }

        $response->output();
    }

    /**
     * 	Assign Roles
     * @deprecated since version 1.1 by Diego Castro
     * */
    public function actionAssign($id) {
        #Validate Assign
        if (Yii::app()->authManager->checkAccess($_GET["item"], $id)) {
            Yii::app()->authManager->revoke($_GET["item"], $id);
            if ($_GET["item"] == "vendor") {
                //Delete WharehousesUser
                if ($wharehouse = WharehousesUser::model()->findAll('user_id = ' . $id))
                    WharehousesUser::model()->deleteAll('user_id = ' . $id);
            }
            Yii::app()->user->setFlash("info", "Rol desasignado correctamente.");
        } else {
            Yii::app()->authManager->assign($_GET["item"], $id);
            Yii::app()->user->setFlash("info", "Rol asignado correctamente.");
        }

        #Redirect
        $this->redirect(array("view", "id" => $id));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model = UserExtend::newUser();

            if (!$model->getErrors())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Usuario creado con exito.');
            else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Usuario vacios; campos marcados con ( * ) son obligatorios.');

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

        if (isset($_POST['User'])) {
            $model = UserExtend::newUser($id);

            if (!$model->getErrors())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Usuario actualizado con exito.');
            else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Usuario vacios; campos marcados con ( * ) son obligatorios.');

            $model->attributes = $_POST['User'];

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

        //Delete WharehousesUser
        if ($wharehouse = WharehousesUser::model()->findAll('user_id = ' . $model->user_id))
            WharehousesUser::model()->deleteAll('user_id = ' . $model->user_id);

        $model->user_status = 3;
        $model->user_lockoutenabled = 1;
        $model->user_lockoutenddateutc = '2099-12-31';
        $model->save();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new UserExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserExtend']))
            $model->attributes = $_GET['UserExtend'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new UserExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserExtend']))
            $model->attributes = $_GET['UserExtend'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * Funcion exportar pdf
     */

    public function actionExportPdf($id) {
        $model = $this->loadModel($id);
        $mPDF1 = Yii::app()->ePdf->mpdf();

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/dashboard/dist/css/AdminLTE.min.css');


        $html = $this->renderPartial('view', array('model' => $model), true);

        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($html, 2);
        $mPDF1->Output();
        exit;
    }

    public function actionBodegas() {
        $id = $_GET['user'];
        $bodega = UserExtend::bodSave();
        //Yii::app()->user->setFlash("info",$tax);


        $this->renderPartial('bodegas', array(
            'model' => $this->loadModel($id),
            'bodegas' => UserExtend::bodegasUser($id),
        ));
        Yii::app()->end();
    }

    public static function actionCitiesByDepartament() {
        $deparment_id = $_POST['User']['deparment_id'];
        $deparment_cod = Departaments::model()->find("deparment_id = ?", array($deparment_id));
        $citiesList = Cities::model()->findAll("city_state = ? AND deparment_cod = ?", array(1, $deparment_cod->deparment_cod));
        $citiesList = CHtml::listData($citiesList, 'city_id', 'city_name');
        foreach ($citiesList as $city_id => $city_name)
            echo CHtml::tag('option', array('value' => $city_id), CHtml::encode($city_name), true);
    }

    public static function actionCitiesByDepartaments() {
        $deparment_id = $_POST['Companies']['deparment_id'];
        $deparment_cod = Departaments::model()->find("deparment_id = ?", array($deparment_id));
        $citiesList = Cities::model()->findAll("city_state = ? AND deparment_cod = ?", array(1, $deparment_cod->deparment_cod));
        $citiesList = CHtml::listData($citiesList, 'city_id', 'city_name');
        foreach ($citiesList as $city_id => $city_name)
            echo CHtml::tag('option', array('value' => $city_id), CHtml::encode($city_name), true);
    }

    public function actionRecoveryPassword() {
        /*
         * recoverypass scenario para que solo tome las validaciones indicadas.
         */
        $model = new User('recoverypass');

        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            //echo '<pre>';
            //print_r($_POST);
            //exit;
            $user = User::model()->model()->findByAttributes(array('user_email' => $_POST['User']['user_email']));
            $pass = UserExtend::generaPass();
            $user->user_passwordhash = md5($pass);
            $user->user_accessfailcount = 0;
            $user->user_status = 1;
            $user->reset_password = 1;
            $user->save();

            $mail = new YiiMailer();
            $mail->setView('recovery_password');
            $mail->setData(array('model' => $user, 'password' => $pass));
            $mail->setLayout('mailer');
            $mail->setFrom(Yii::app()->params['adminEmail']);

            $mail->setTo(array($user->user_email));
            $mail->setSubject('Recuperación de contraseña ' . $user->user_name);

            $mail->send();
            $datosConf = array('estado' => 'success', 'mensaje' => 'Se ha enviado un correo electronico con los datos de acceso. ');
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('/site/login'));
        }

        $this->renderPartial('/site/recovery_form', array('model' => $model), false, true);
    }

    public function actionNewRegister() {
        $model = new Companies;
        $model1 = new User('registertest');

        $this->performAjaxValidation(array($model1, $model));

        if (isset($_POST['Companies']) && isset($_POST['User'])) {


            $model = CompaniesExtend::newCompanyRegister();

            if ($model)
                $datosConf = array('estado' => 'success', 'mensaje' => 'La Empresa ha sido registrada con exito. Datos enviados al email.');
            else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Empresa vacios; campos marcados con ( * ) son obligatorios.');

            $model->attributes = $_POST['Companies'];
            $model1->attributes = $_POST['User'];
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('/site/login'));

            print_r(json_encode($datosConf));
            exit;
        }

        $this->renderPartial('/site/register_form', array('model' => $model, 'model1' => $model1), false, true);
    }

    public function actionChangePassword() {
        $model = new User('updatepass');

        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $user = User::model()->model()->findByPk(Yii::app()->user->id);
            $user->user_passwordhash = md5($_POST['User']['new_password']);
            $user->reset_password = 0;
            if ($user->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Se ha realizado el cambio de la contraseña correctamente.');
            } else {
                $datosConf = array('estado' => 'danger', 'mensaje' => 'No se realizo la actualización');
            }
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('/site/index'));
        }

        $this->renderPartial('/site/change_form', array('model' => $model), false, true);
    }

    public function actionDataUser($id) {
        $datosUser = User::model()->findBypk($id);
        $datosUser->scenario='updateUser';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($datosUser);
        
         if (isset($_POST['User'])) {
             $datosUser->user_name = $_POST['User']['user_name'];
             $datosUser->user_email = $_POST['User']['user_email'];
             $datosUser->user_status = $_POST['User']['user_status'];
             if($_POST['User']['new_password']){
                $datosUser->user_passwordhash = md5($_POST['User']['new_password']) ;
             }
             $datosUser->save();
             print_r($datosUser->errors);exit;             
         }

        $this->renderPartial('/companies/_modal_user_edit', array('model' => $datosUser), false, true);
    }

    public function actionDataCustomer() {
        $purifier = Purifier::getInstance();
        $user = U::getInstance();
        $id = $purifier->purify($_POST['user_id']);        
        $datosUser->scenario='updateCustomer';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($datosUser);
        
		if (isset($_POST['User'])) {
			$pass = UserExtend::generaPass();
			$datosCustomer = Customers::model()->findByPk($id);
			$ussers = $datosUser = User::model()->findByPk($id);
			if ($datosUser === null){
			    $datosUser = new User;
			    $datosUser->user_passwordhash = $datosUser->repeat_password = md5($pass);
			}

			$attributes = $purifier->purify($_POST['User']);
			$datosUser->attributes = $attributes;
			$datosUser->user_id = $datosCustomer->customer_nit;
			$datosUser->user_firtsname = $datosCustomer->customer_firtsname;
			$datosUser->user_lastname = $datosCustomer->customer_lastname;
			$datosUser->user_phone = $datosCustomer->customer_phone;
			$datosUser->user_address = $datosCustomer->customer_address;
			$datosUser->user_emailconfirmed = "0";
			$datosUser->user_phonenumberconfirmed = "0";
			$datosUser->user_lockoutenabled = "0";
			$datosUser->user_accessfailcount = "0";
			$datosUser->reset_password = (!$ussers) ? "1" : "0";
			$datosUser->user_lockoutenddateutc = date('Y-m-d');
			$datosUser->deparment_id = $datosCustomer->deparment_id;
			$datosUser->city_id = $datosCustomer->city_id;
			$datosUser->company_id = $user->CompanyId;
			$datosUser->user_name = $_POST['User']['user_name'];
			$datosUser->user_email = $_POST['User']['user_email'];
			$datosUser->user_status = $_POST['User']['user_status'];
			$datosUser->user_photo = 'user2-160x160.jpg';

			//Update Email
			$datosCustomer->customer_email = $_POST['User']['user_email'];

			if($datosUser->save() && $datosCustomer->save()){
			    if(!$ussers){
			        $status = "Usuario creado con exito.";
			        if($datosUser->user_email)
			            UserExtend::mailUser($datosUser, $pass);

			        $auth = Yii::app()->authManager;
			        $auth->assign('customer', $datosUser->user_id);
			    }else
			        $status = "Usuario actualizado con exito";
			}            

			if (!$datosUser->getErrors())
			    $datosConf = array('estado' => 'success', 'mensaje' => $status);
			else{
			    $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Usuario vacios; campos marcados con ( * ) son obligatorios. '. CHtml::errorSummary($datosCustomer));
			}

			print_r(json_encode($datosConf));
			exit;            
		}
    }

    public function actionDataSupplier() {
        $purifier = Purifier::getInstance();
        $user = U::getInstance();
        $id = $purifier->purify($_POST['user_id']);        
        $datosUser->scenario='updateCustomer';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($datosUser);
        
        //Send Data
		if (isset($_POST['User'])) {
			$pass = UserExtend::generaPass();
			$datosSupplier = Suppliers::model()->findByPk($id);			
			$ussers = $datosUser = User::model()->findByPk($id);
			//Validate User
			if ($datosUser === null){
			    $datosUser = new User;
			    $datosUser->user_passwordhash = $datosUser->repeat_password = md5($pass);
			}
			//Load Attributes
			$attributes = $purifier->purify($_POST['User']);
			$datosUser->attributes = $attributes;
			$datosUser->user_id = $datosSupplier->supplier_nit;
			$datosUser->user_firtsname = $datosSupplier->supplier_name;
			$datosUser->user_lastname = $datosSupplier->contact_name;
			$datosUser->user_phone = $datosSupplier->supplier_phone;
			$datosUser->user_address = $datosSupplier->supplier_address;
			$datosUser->user_emailconfirmed = "0";
			$datosUser->user_phonenumberconfirmed = "0";
			$datosUser->user_lockoutenabled = "0";
			$datosUser->user_accessfailcount = "0";
			$datosUser->reset_password = (!$ussers) ? "1" : "0";
			$datosUser->user_lockoutenddateutc = date('Y-m-d');
			$datosUser->deparment_id = $datosSupplier->deparment_id;
			$datosUser->city_id = $datosSupplier->city_id;
			$datosUser->company_id = $user->CompanyId;
			$datosUser->user_name = $_POST['User']['user_name'];
			$datosUser->user_email = $_POST['User']['user_email'];
			$datosUser->user_status = $_POST['User']['user_status'];
			$datosUser->user_photo = 'user2-160x160.jpg';

			//Update Email
			$datosSupplier->supplier_email = $_POST['User']['user_email'];
			
			//Save Information
			if($datosUser->save() && $datosSupplier->save()){
			    if(!$ussers){
			        $status = "Usuario creado con exito.";
			        if($datosUser->user_email)
			            UserExtend::mailUser($datosUser, $pass);

			        $auth = Yii::app()->authManager;
			        $auth->assign('supplier', $datosUser->user_id);
			    }else
			        $status = "Usuario actualizado con exito";
			}            

			//Valdiate Errors
			if (!$datosSupplier->getErrors())
			    $datosConf = array('estado' => 'success', 'mensaje' => $status);
			else				
			    $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Usuario vacios; campos marcados con ( * ) son obligatorios. '. CHtml::errorSummary($datosSupplier));

			print_r(json_encode($datosConf));
			exit;            
		}
    }
}
