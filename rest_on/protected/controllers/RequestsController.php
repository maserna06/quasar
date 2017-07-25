<?php
class RequestsController extends Controller {

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
                'actions' => array('index', 'indexes', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'viewproducts', 'clientetax','request','requestdetail','detailview'),
                'roles' => array('super', 'admin', 'supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('super', 'admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('clientetax','request','requestdetail','detailview','request','viewproducts'),
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

        $model = $this->loadModel($id);
        $datos = RequestsExtend::datos();
        $datos['RequestConfig']->request_id = $model->request_consecut;
        $datos['products'] = RequestsExtend::productsRequest($id);

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

        $model = new Requests;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Requests'])) {
            $model->attributes = $_POST['Requests'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->request_id));
                Yii::app()->user->setFlash("success", "Pedido creado correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "Datos de Pedido vacios; campos marcados con ( * ) son obligatorios.");
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
        $datos = RequestsExtend::datos();
        $datos['RequestConfig']->request_id = $model->request_consecut;
        $datos['products'] = RequestsExtend::productsRequest($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Requests'])) {
           $model = RequestsExtend::saveRequest($id);
           $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Pedido # ' . $model->request_consecut . ' se ha actualizado.');
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('update', 'id' => $model->request_id));
            
        }

        $this->render('update', array(
            'model' => $model,
            'datos'=>$datos,
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
        $model->request_status = 3;
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

        $model = new Requests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];

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

        $model = new Requests;
        $datos = RequestsExtend::datos();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Requests'])) {
           $model = RequestsExtend::saveRequest();
           if ($model->request_consecut) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Pedido # '.$model->request_consecut.' fue cerada.');
            }else {
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
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Requests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Requests the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Requests::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Requests $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'requests-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionViewProducts() {

        $model = RequestsExtend::viewProducts();

        $this->renderPartial('/products/viewModal', array('model' => $model), false, true);
    }

    public function actionClienteTax() {

        $id = $_POST['id'];
        $customer = Customers::model()->findByPk($id);
        $sql = Yii::app()->db->createCommand();
        $sql->select('sum(t.tax_rate)');
        $sql->from('tbl_taxes_customer tp');
        $sql->join('tbl_taxes t', 'tp.tax_id = t.tax_id');
        $sql->where('tp.customer_nit = ' . $id);
        $sql->andWhere('t.tax_ishighervalue = 1');
        $imp = $sql->queryScalar();
        if ($imp)
            $tax['tax'] = $imp / 100;
        else
            $tax['tax'] = 0;
        $tax['des'] = ($customer->customer_discount > 0) ? $customer->customer_discount / 100 : $customer->customer_discount;
        $tax['mail'] = ($customer->customer_email)?1:0;
        $tax = json_encode($tax);
        echo $tax;
        exit;
    }
    
    public function actionRequest() {
        $request = Requests::model()->findByattributes(array('request_id' => $_POST['id']));
        $datos['cuenta'] = $request->accounts_id;
        $datos['cliente'] = $request->customer_nit;
        $datos['obs'] = $request->request_remarks;
        echo json_encode($datos);
        exit;
    }
    
    public function actionRequestDetail() {
        //$request = Requests::model()->findByattributes(array('order_id' => $_POST['id']));
        $porducts = RequestsExtend::productsRequest($_POST['id']);
        echo $porducts;
        exit;
    }
    
    public function actionDetailView() {

        $id = $_GET['id_detail'];
        $cant = $_GET['cantidad'];
        $product = RequestsDetails::model()->findByPk($id);
//        echo'<pre>';
//        print_r($product);exit;
        $components = NULL;
        if ($product->request_details_price == $product->product->product_price) {
            $tax = ProductsExtend::addProdTax($product->product_id);
        }
        if ($tax > 0)
            $tax = 1 + ($tax / 100);
        else
            $tax = 1;
        $components = RequestsDetailsComponent::model()->findAllByAttributes(array('requests_details_id'=>$id));
        if($components){
            $datosCom = array();
                $i=0;
                foreach ($components as $comp){
                    $datosCom[$i]['product_id']= $comp->product_id;
                    $datosCom[$i]['name'] = $comp->product->product_description;
                    $datosCom[$i]['unit_id'] = $comp->unit_id;
                    $datosCom[$i]['quantity'] = $comp->requests_details_component_quantity;
                    $i++;
                }
                $components = json_encode($datosCom);
            
        }
        $datos['name'] = $product->product->product_description;
        $datos['image'] = Yii::app()->theme->baseUrl.'/dist/img/'.$product->product->product_image;
        $datos['product_id'] = $product->product->product_id;
        $datos['wharehouse_id'] = $product->wharehouse_id;
        $datos['quantity'] = $product->request_details_quantity;
        $datos['unit_id'] = $product->unit_id;
        $datos['price'] = $product->request_details_price;
        $datos['price_real'] = $product->product->product_price;
        $datos['total'] = $product->request_details_quantity * $product->request_details_price;
        $this->renderPartial('/products/productStoreUpdate', array('cant' => $cant, 'product' => $datos, 'tax' => $tax, 'components' => $components));
        exit;
    }
}
