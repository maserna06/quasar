<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;
use App\Utils\JsonResponse;

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        if (Yii::app()->user->getId() === null) {
            $this->redirect(array('site/login'));
        } else {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if ($user)
                Yii::app()->getSession()->add('empresa', $user->company_id);
            $this->render('index');
        }
    }

    /**
     * Save Menu state
     */
    public function actionSaveMenuState() {
        $user = U::getInstance();
        if (!$user->me->isGuest) {
            $state = Yii::app()->request->getParam('sidebar-state', null);
            $user->sidebarState = $state;
        }
        Yii::app()->end();
    }

    /**
    * Initial Task Events by Modal View
    * Task_ :: Users_
    */
    public function actionTaskbyUser() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) Yii::app()->user->id;    
        $query = Yii::app()->db->createCommand();
        $query->select([
            't.task_id',
            't.title', 
            't.start', 
            't.end', 
            't.backgroundcolor', 
            't.bordercolor', 
            't.task_progress',
        ])
        ->from('tbl_task t')
        ->leftJoin('tbl_task_user tu', 'tu.task_id = t.task_id')
        ->andWhere('tu.user_id = :id', [':id' => $id]);

        $TaskbyUser = $query->queryAll();
        $template = '
            <li id="task_0">
                <span class="handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                </span>
                <input type="checkbox" value="" style="min-height: 0;width: 3% !important;">
                <span class="text"></span>
                <small class="label" style="background-color:#FFF;">
                    <i class="fa fa-clock-o"></i> 0 dias
                </small>
                <div class="tools">
                    <i class="fa fa-edit" id="edit_0"></i>
                    <i class="fa fa-trash-o" id="trash_0"></i>
                </div>
            </li>
        ';
        
        $response->set('TaskbyUser', $TaskbyUser)
            ->set('template', $template)
            ->output();
    }

    public function actionUserTask() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) Yii::app()->user->id;    
        $query = Yii::app()->db->createCommand();
        $query->select([
                    'u.user_id',
                    'CONCAT ( u.user_firtsname, " ", u.user_lastname) AS name',
                ])
                ->from('tbl_user u')
                ->Where('u.user_id = :id', [':id' => $id]);

        $taskUser = $query->queryAll();
        $template = '
          <tr>
            <td>
              <div class="TaskUser"></div>
              <input type="hidden" name="TaskUser[user_id][]" class="TaskUser_user_id" />
            </td>
            <td align="center">
              <a href="#" class="remove"><i class="fa fa-times"></i></a>
            </td>
          </tr>
        ';
        $response->set('taskUser', $taskUser)
          ->set('template', $template)
          ->output();
    }

    public function actionUsersTask() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) $_POST['idTask'];
        //print_r($id); exit;
        $query = Yii::app()->db->createCommand();
        $query->select([
                    'u.user_id',
                    'CONCAT ( u.user_firtsname, " ", u.user_lastname) AS name',
                ])
                ->from('tbl_user u')
                ->Join('tbl_task_user tu', 'tu.user_id = u.user_id')
                ->Where('tu.task_id = :id', [':id' => $id]);

        $taskUser = $query->queryAll();
        $template = '
          <tr>
            <td>
              <div class="TaskUser"></div>
              <input type="hidden" name="TaskUser[user_id][]" class="TaskUser_user_id" />
            </td>
            <td align="center">
              <a href="#" class="remove"><i class="fa fa-times"></i></a>
            </td>
          </tr>
        ';
        $response->set('taskUser', $taskUser)
          ->set('template', $template)
          ->output();
    }

    public function actionLoadTask() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();      

        $id = (int) $_POST['idTask'];

        $query = Yii::app()->db->createCommand();
        $query->select(['t.*'])
            ->from('tbl_task t')
            ->where('t.task_id = '.$id)
            ->andWhere('t.task_visible = 1')
            ->andWhere('t.task_state = 1');

        $alltask = $query->queryAll();

        $response->set('alltask', $alltask)
            ->output();
    }

    public function actionAutocomplete() {
        $purifier = Purifier::getInstance();
        $user = U::getInstance();

        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            $term = strtoupper($term);
            $query = Yii::app()->db->createCommand();
            $query->select([
                        'user_id',
                        'CONCAT ( user_firtsname, " ", user_lastname) AS user_name',
                    ])->from('tbl_user')
                    ->andWhere('user_firtsname LIKE :name', [':name' => '%' . $term . '%'])
                    ->orWhere('user_lastname LIKE :name', [':name' => '%' . $term . '%'])
                    ->andWhere('user_status = 1');
            if (!$user->isSuper) {
                $query->andWhere('company_id=:company_id', [':company_id' => $user->companyId]);
            }
            $res = $query->queryAll();
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }

    public function actionRemoveUserTask() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();

        $id = (int) $_POST['idTask'];    
        $user_id = $_POST['userId'];

        //Delete Row
        if (TaskUser::model()->deleteAll('task_id = ' . $id . ' and user_id = ' . $user_id))
          $datosConf = array('estado' => 'success', 'mensaje' => 'Usuario desasignado con exito.');
        else
          $datosConf = array('estado' => 'danger', 'mensaje' => 'El usuario no se desasigno.');

        print_r(json_encode($datosConf));
        exit;
    }

    public function actionAddTaskAll() {
        if (Yii::app()->user->getId() === null)
          $this->redirect(array('site/login'));

        $purifier = Purifier::getInstance();
        $user = U::getInstance();

        if (isset($_POST['Taskmodal'])) {
            $id = $_POST['Taskmodal']['Taskmodal_id'];
            
            //Validate ID in Event (Copy Event)
            if($id != "")
              $model = Task::model()->findByPk($id);
            else
              $model = new Task;

            //Set Attributes
            $model->title = $_POST['Taskmodal']['titlemodal'];
            $model->start = $_POST['Taskmodal']['start']." ".$_POST['Taskmodal']['startmm'];
            $model->end = $_POST['Taskmodal']['end']." ".$_POST['Taskmodal']['endmm'];
            $model->description = $_POST['Taskmodal']['description'];      
            $model->backgroundcolor = $_POST['Taskmodal']['backgroundcolor'];
            $model->bordercolor = $_POST['Taskmodal']['bordercolor'];
            $model->task_progress = $_POST['Taskmodal']['Taskmodal_progress'];
            $model->task_state = 1;
            //Validate null visibility (Copy Event)
            $model->task_visible = (isset($_POST['Taskmodal']['Taskmodal_visible'])) ? ($_POST['Taskmodal']['Taskmodal_visible'] == "on") ? '1' : '0' : '0';
            
            if($model->save())
            {
              //Return PK
              $pk = $model->getPrimaryKey();
              //Validate is_null (Copy Event)
              if($id == "")
              {
                $model1 = new TaskUser;
                $model1->task_id = $pk;
                $model1->user_id = $user->meId;
                $model1->save();
              }
              
              //Repeat Event -> Pendiente
              $repeat = (isset($_POST['Taskmodal']['repeat'])) ? ($_POST['Taskmodal']['repeat'] == "on") ? '1' : '0' : '0';
              
              //Row Data
              foreach ($_POST['TaskUser']['user_id'] as $valor)
              {
                $model1 = new TaskUser;
                //Validate User Asign
                $model1->task_id = $pk;
                $model1->user_id = $valor;
                if(!(TaskUser::model()->find('task_id = '.$pk.' and user_id ='.$valor))) //Validate no_exist (Copy Event)
                  $model1->save();
                //Send email
                $email = (isset($_POST['Taskmodal']['email'])) ? ($_POST['Taskmodal']['email'] == "on") ? '1' : '0' : '0';
                //Send Mail
                if($email == '1')
                {
                  $user = User::model()->findByPk($model1->user_id);
                  if(isset($user->user_email))
                  {
                    $mail = new YiiMailer();
                    $mail->setView('task');
                    $mail->setData(array('model' => $model));
                    $mail->setLayout('mailer');
                    $mail->setFrom(Yii::app()->params['adminEmail']);
                    $mail->setTo(array('john.cubides87@gmail.com', $user->user_email));
                    $mail->setSubject('Tarea : ' . $model->title);
                    $mail->send();
                  }
                }
              }
              $datosConf = array('estado' => 'success', 'mensaje' => $pk);  
            }
            else
            $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Tarea vacios; campos marcados con ( * ) son obligatorios.');
            print_r(json_encode($datosConf));
            exit;
        }
    }
   
    /**
    * Initial Event by Modal View
    * Purchases_ :: Sales_ :: Users_ :: Reports_
    */
    public function actionPurchasesAutocomplete($term) {
        $criteria = new CDbCriteria;
        $criteria->compare('LOWER(purchase_consecut)', strtolower($_GET['term']), true);
        $criteria->limit = 30;
        $data = Purchases::model()->findAll($criteria);

        if (!empty($data)) {
            $arr = array();
            foreach ($data as $item) {
                $arr[] = array(
                    'id' => $item->purchase_consecut,
                    'value' => $item->purchase_consecut,
                    'label' => $item->purchase_consecut
                );
            }
        } else {
            $arr = array();
            $arr[] = array(
                'id' => '',
                'value' => 'No se han encontrado resultados',
                'label' => 'No se han encontrado resultados',
            );
        }
        echo CJSON::encode($arr);
    }

    public function actionSalesAutocomplete($term) {
        $criteria = new CDbCriteria;
        $criteria->compare('LOWER(sale_consecut)', strtolower($_GET['term']), true);
        $criteria->limit = 30;
        $data = Sales::model()->findAll($criteria);

        if (!empty($data)) {
            $arr = array();
            foreach ($data as $item) {
                $arr[] = array(
                    'id' => $item->sale_consecut,
                    'value' => $item->sale_consecut,
                    'label' => $item->sale_consecut
                );
            }
        } else {
            $arr = array();
            $arr[] = array(
                'id' => '',
                'value' => 'No se han encontrado resultados',
                'label' => 'No se han encontrado resultados',
            );
        }
        echo CJSON::encode($arr);
    }

    public function actionUsersAutocomplete($term) {
        $criteria = new CDbCriteria;
        $criteria->compare('LOWER(user_name)', strtolower($_GET['term']), true, 'OR');
        $criteria->compare('LOWER(user_firtsname)', $_GET['term'], true, 'OR');
        $criteria->compare('LOWER(user_lastname)', strtolower($_GET['term']), true, 'OR');
        $criteria->compare('LOWER(user_id)', strtolower($_GET['term']), true, 'OR');
        $criteria->limit = 30;
        $data = User::model()->findAll($criteria);

        if (!empty($data)) {
            $arr = array();
            foreach ($data as $item) {
                $arr[] = array(
                    'id' => $item->user_id,
                    'value' => $item->user_firtsname . " " . $item->user_lastname,
                    'label' => $item->user_firtsname . " " . $item->user_lastname
                );
            }
        } else {
            $arr = array();
            $arr[] = array(
                'id' => '',
                'value' => 'No se han encontrado resultados',
                'label' => 'No se han encontrado resultados',
            );
        }
        echo CJSON::encode($arr);
    }

    public function actionCompra($id) {
        $purchase = Purchases::model()->findByAttributes(array('purchase_id' => $id));
        $account = Accounts::model()->findByPk($purchase->accounts_id);
        $company = Companies::model()->findByPk($purchase->company_id);
        $user = User::model()->findByPk($purchase->user_id);
        $supplier = Suppliers::model()->findByPk($purchase->supplier_nit);
        $purchaseJson = array('purchase_consecut' => $purchase->purchase_consecut,
            'purchase_date' => $purchase->purchase_date,
            'purchase_order_id' => $purchase->order_id,
            'purchase_net_worth' => " $ " . number_format($purchase->purchase_net_worth, 0, ",", "."),
            'purchase_account_name' => $account->account_name,
            'purchase_status' => $purchase->purchase_status,
            'purchase_company_logo' => Yii::app()->theme->baseUrl . '/dist/img/' . $company->company_logo,
            'purchase_company_name' => $company->company_name,
            'purchase_company_address' => $company->company_address,
            'purchase_supplier_name' => $supplier->supplier_name,
            'purchase_supplier_phone' => $supplier->supplier_phone,
            'purchase_supplier_address' => $supplier->supplier_address,
            'purchase_supplier_contact' => $supplier->contact_name,
            'purchase_user_name' => $user->user_firtsname . " " . $user->user_lastname,
        );

        echo CJSON::encode($purchaseJson);
    }

    public function actionCompraAjax() {
        $purchase = Purchases::model()->findByAttributes(array(
            'purchase_consecut' => $_GET['id']));
        $purchaseJson = array(
            'purchase_id' => $purchase->purchase_id,
            'purchase_consecut' => $purchase->purchase_consecut,
            'purchase_order_id' => $purchase->order_id,
            'purchase_date' => $purchase->purchase_date,
            'purchase_status' => $purchase->purchase_status,
        );
        echo CJSON::encode($purchaseJson);
    }

    public function actionVenta($id) {
        $sale = Sales::model()->findByAttributes(array('sale_id' => $id));
        $account = Accounts::model()->findByPk($sale->accounts_id);
        $company = Companies::model()->findByPk($sale->company_id);
        $user = User::model()->findByPk($sale->user_id);
        $customer = Customers::model()->findByPk($sale->customer_nit);
        $saleJson = array('sale_consecut' => $sale->sale_consecut,
            'sale_date' => $sale->sale_date,
            'sale_request_id' => $sale->request_id,
            'sale_net_worth' => " $ " . number_format($sale->sale_net_worth, 0, ",", "."),
            'sale_account_name' => $account->account_name,
            'sale_status' => $sale->sale_status,
            'sale_company_logo' => Yii::app()->theme->baseUrl . '/dist/img/' . $company->company_logo,
            'sale_company_name' => $company->company_name,
            'sale_company_address' => $company->company_address,
            'sale_customer_name' => $customer->customer_firtsname . " " . $customer->customer_lastname,
            'sale_customer_phone' => $customer->customer_phone,
            'sale_customer_address' => $customer->customer_address,
            'sale_customer_contact' => $customer->customer_firtsname . " " . $customer->customer_lastname,
            'sale_user_name' => $user->user_firtsname . " " . $user->user_lastname,
        );
        echo CJSON::encode($saleJson);
    }

    public function actionVentaAjax() {
        $sale = Sales::model()->findByAttributes(array(
            'sale_consecut' => $_GET['id']));
        $saleJson = array(
            'sale_id' => $sale->sale_id,
            'sale_consecut' => $sale->sale_consecut,
            'sale_request_id' => $sale->request_id,
            'sale_date' => $sale->sale_date,
            'sale_status' => $sale->sale_status,
        );
        echo CJSON::encode($saleJson);
    }

    public function actionUsuarioAjax() {
        $criteria = new CDbCriteria;
        $criteria->compare('user_name', $_GET["term"], true, "OR");
        $criteria->compare('user_id', $_GET["term"], true, "OR");
        $criteria->compare('user_firtsname', $_GET["term"], true, "OR");
        $criteria->compare('user_lastname', $_GET["term"], true, "OR");

        $users = User::model()->findAll($criteria);
        $roles = "";
        foreach ($users as $user) {
            foreach (Yii::app()->authManager->getAuthItems(2, $user->user_id) as $role) {
                $roles = $roles . "<span class='label label-success'>" . $role->name . "</span> ";
            }
            $usersArray[] = array(
                'user_name' => $user->user_firtsname . " " . $user->user_lastname,
                'user_photo' => Yii::app()->theme->baseUrl . '/dist/img/' . $user->user_photo,
                'user_roles' => $roles,
            );
            $roles = "";
        }
        echo CJSON::encode($usersArray);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        //Change Layout Login
        $this->layout = 'loginLayout';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $usuario = User::model()->findByAttributes(array('user_name' => $model->user_name));

            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $usuario->user_accessfailcount = 0;
                $this->layout = 'main';
                $usuario->update();
                Yii::app()->user->setState('empresa', $usuario->company_id);
                //$this->redirect(array("index"));
                $datosConf = array('estado' => 'success', 'mensaje' => "Bienvenido!");
            } else {
                $msj = 'Acceso denegado; campos marcados con ( * ) son obligatorios.';
                if ($usuario) {
                    $usuario->user_accessfailcount = ($usuario->user_accessfailcount + 1 >= 3) ? 3 : $usuario->user_accessfailcount + 1;
                    if ($usuario->user_accessfailcount == 3) {
                        $msj .= '<br><b>Acceso denegado; Usuario bloqueado por numero de intentos.</b>';
                        $usuario->user_status = 0;
                    }
                }
                $datosConf = array('estado' => 'danger', 'mensaje' => $msj);                
            }
            if ($usuario)
                $usuario->update();

            print_r(json_encode($datosConf));
        	exit;
        }
        //Validate Var User Session
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
