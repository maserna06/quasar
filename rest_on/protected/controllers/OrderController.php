<?php

class OrderController extends Controller {

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
                'actions' => array('index', 'create', 'update', 'fastproduct', 'viewproducts', 'proveedortax', 'detailview', 'orderdetail', 'order'),
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
        $datos = OrderExtend::datos();
        $datos['orderConfig']->order_id = $model->order_consecut;
        $datos['products'] = OrderExtend::productsOrder($id);

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

        $model = new Order;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->order_id));
                Yii::app()->user->setFlash("success", "Orden creado correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "Datos de Orden vacios; campos marcados con ( * ) son obligatorios.");
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
        $datos = OrderExtend::datos();
        $datos['orderConfig']->order_id = $model->order_consecut;
        $datos['products'] = OrderExtend::productsOrder($id);

//        echo '<pre>';
//        print_r($datos);Exit;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Order'])) {
            $model = OrderExtend::saveOrder($id);
            $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Orden # ' . $model->order_consecut . ' se ha actualizado');
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('update', 'id' => $model->order_id));
            
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
        $model->order_status = 3;
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

        $model = new OrderExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderExtend']))
            $model->attributes = $_GET['OrderExtend'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        //Yii::app()->crugemailer->pruebaMail('jcubides@inc-pro.co');

        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Order;
        $datos = OrderExtend::datos();


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Order'])) {
//            echo '<pre>';
//            print_r($_POST);exit;
            $model = OrderExtend::saveOrder();
            if ($model->order_consecut) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de orden  #' . $model->order_consecut . ' fue creada.');
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

        $model = new OrderExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderExtend']))
            $model->attributes = $_GET['OrderExtend'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Order the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Order::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Order $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionFastProduct() {
        $model = new Products;

        $this->performAjaxValidation($model);

        if (isset($_POST['Products'])) {

            $model = ProductsExtend::newProduct();
            $this->setMessages(true, $model->getErrors());
        }
        //No Carga JQuery
        Yii::app()->clientScript->registerCoreScript('yiiactiveform');
        Yii::app()->clientScript->corePackages = array();
        Yii::app()->clientScript->scriptMap = array(
            'jquery.js' => false,
            'jquery.min.js' => false,
        );
        //$this->renderPartial('/products/fastProduct', array('model' => $model), false, true);
        echo $this->renderPartial('/products/fastProduct', array('model' => $model), true, true);
        Yii::app()->end();
    }

    public function actionViewProducts() {

        $model = OrderExtend::viewProducts();

        $this->renderPartial('/products/viewModal', array('model' => $model), false, true);
    }

    public function actionProveedorTax() {

        $id = $_POST['id'];
        $supllier = Suppliers::model()->findByPk($id);
        $sql = Yii::app()->db->createCommand();
        $sql->select('sum(t.tax_rate)');
        $sql->from('tbl_taxes_supplier tp');
        $sql->join('tbl_taxes t', 'tp.tax_id = t.tax_id');
        $sql->where('tp.supplier_nit = ' . $id);
        $sql->andWhere('t.tax_ishighervalue = 1');
        $imp = $sql->queryScalar();
        if ($imp)
            $tax['tax'] = $imp / 100;
        else
            $tax['tax'] = 0;
        $tax['des'] = ($supllier->supplier_discount > 0) ? $supllier->supplier_discount / 100 : $supllier->supplier_discount;
        $tax['mail'] = ($supllier->supplier_email) ? 1 : 0;
        $tax = json_encode($tax);
        echo $tax;
        exit;
    }

    public function actionDetailView() {

        $id = $_GET['id_detail'];
        $cant = $_GET['cantidad'];
        $product = OrderDetails::model()->findByPk($id);

        if ($product->order_details_price == $product->product->product_price) {
            $tax = ProductsExtend::addProdTax($product->product_id);
        }
        if ($tax > 0)
            $tax = 1 + ($tax / 100);
        else
            $tax = 1;
        $this->renderPartial('/products/prodComprasUpdate', array('cant' => $cant, 'product' => $product, 'tax' => $tax));
        exit;
    }

    public function actionOrderDetail() {
        $orden = Order::model()->findByattributes(array('order_id' => $_POST['id']));
        $porducts = OrderExtend::productsOrder($orden->order_id);
        echo $porducts;
        exit;
    }

    public function actionOrder() {
        $orden = Order::model()->findByattributes(array('order_id' => $_POST['id']));
        $datos['cuenta'] = $orden->accounts_id;
        $datos['proveedor'] = $orden->supplier_nit;
        $datos['obs'] = $orden->order_remarks;
        echo json_encode($datos);
        exit;
    }

}
