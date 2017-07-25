<?php

class SalesController extends Controller {

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
                'actions' => array('salesMonthlyIncrement', 'index', 'indexes', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'config', 'viewproducts', 'clientetax', 'DetailView','indexCharts'),
                'roles' => array('super', 'admin', 'supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('super', 'admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('clientetax','DetailView','viewproducts'),
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
        $datos = SalesExtend::datos();
        $datos['saleConfig']->sale_id = $model->sale_consecut;
        $datos['products'] = SalesExtend::productsSale($id);
        $this->render('view', array(
            'model' => $model,
            'datos' => $datos
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Sales;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Sales'])) {
            $model->attributes = $_POST['Sales'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->sale_id));
                Yii::app()->user->setFlash("success", "Sales creado correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "Datos de Sales vacios; campos marcados con ( * ) son obligatorios.");
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
        $datos = SalesExtend::datos();
        $datos['saleConfig']->sale_id = $model->sale_consecut;
        $datos['products'] = SalesExtend::productsSale($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Sales'])) {
            $model = SalesExtend::saveSale($id);
            $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Venta # ' . $model->sale_consecut . ' se ha actualizado.');
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('update', 'id' => $model->sale_id));
        }

        $this->render('update', array(
            'model' => $model,
            'datos' => $datos
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
        $model->sale_status = 3;
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

        $model = new Sales;
        $datos = SalesExtend::datos('tbl_sales');


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Sales'])) {
            $model = SalesExtend::saveSale();
            if($model->sale_consecut){
            $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Venta # ' . $model->sale_consecut . ' fue creada.');
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
     * Lists all models.
     */
    public function actionIndexes() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Sales('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sales']))
            $model->attributes = $_GET['Sales'];

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

        $id = RequestConfigExtend::pedidosCreate();
        if (!$id) {
            $model = new RequestConfig;
        } else {
            $model = RequestConfig::model()->findByPk($id);
            $model->scenario = 'existe';
        }

        $id1 = RequestConfigExtend::remisionesCreate();
        if (!$id1) {
            $model1 = new ReferralConfig;
        } else {
            $model1 = ReferralConfig::model()->findByPk($id1);
            $model1->scenario = 'existe';
        }

        $id2 = RequestConfigExtend::ventasCreate();
        if (!$id2) {
            $model2 = new SaleConfig;
        } else {
            $model2 = SaleConfig::model()->findByPk($id2);
            $model2->scenario = 'existe';
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model, $model1, $model2));

        if (isset($_POST['RequestConfig'])) {
            $model->attributes = $_POST['RequestConfig'];
            if ($model->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración de pedido guardada con éxito.');
                //$this->redirect('config', array('model' => $model, 'model1' => $model1, 'model2' => $model2));
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


        if (isset($_POST['ReferralConfig'])) {
            $model1->attributes = $_POST['ReferralConfig'];
            $model1->referral_payment = ($model1->referral_payment == 'on') ? 1 : 0;
            if ($model1->save()) {
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

        if (isset($_POST['SaleConfig'])) {
            $model2->attributes = $_POST['SaleConfig'];
            $model2->sale_payment = ($model2->sale_payment == 'on') ? 1 : 0;
            if ($model2->save()) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Configuración de venta guardada con éxito.');
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

        $model = new Sales('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sales']))
            $model->attributes = $_GET['Sales'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Sales the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Sales::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Sales $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sales-form') {
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
        $tax = json_encode($tax);
        echo $tax;
        exit;
    }

    public function actionSalesMonthlyIncrement() {

        $today = date("Y-m-d");
        $todayLessOneMonth = strtotime('-1 month', time());
        $todayLessOneMonth = date("Y-m-d", $todayLessOneMonth);
        $todayLessTwoMonths = strtotime('-2 month', time());
        $todayLessTwoMonths = date("Y-m-d", $todayLessTwoMonths);

        $sql = Yii::app()->db->createCommand();
        $sql->select('sum(s.sale_total) as total_current_month');
        $sql->from('tbl_sales s');
        $sql->where("s.sale_date >= '" . $todayLessOneMonth . "' and " . "s.sale_date < '" . $today . "'");
        $salesCurrentMonth = $sql->queryScalar();

        $sql = Yii::app()->db->createCommand();
        $sql->select('sum(s.sale_total) as total_last_month');
        $sql->from('tbl_sales s');
        $sql->where("s.sale_date >= '" . $todayLessTwoMonths . "' and " . "s.sale_date < '" . $todayLessOneMonth . "'");
        $salesLastMonth = $sql->queryScalar();
        if ($salesLastMonth != 0) {
            $salesPtage = (($salesCurrentMonth / $salesLastMonth) - 1) * 100;
            $salesPtage = $salesPtage < 0 ? 0 : $salesPtage;
        } else {
            $salesPtage = 0;
        }
        echo number_format($salesPtage, 0, ",", ".");
    }

    public function actionDetailView() {
        $id = $_GET['id_detail'];
        $cant = $_GET['cantidad'];
        $product = SalesDetails::model()->findByPk($id);
//        echo'<pre>';
//        print_r($product);exit;
        $components = NULL;
        if ($product->sale_details_price == $product->product->product_price) {
            $tax = ProductsExtend::addProdTax($product->product_id);
        }
        if ($tax > 0)
            $tax = 1 + ($tax / 100);
        else
            $tax = 1;
        $components = SalesDetailsComponent::model()->findAllByAttributes(array('sales_details_id' => $id));
        if ($components) {
            $datosCom = array();
            $i = 0;
            foreach ($components as $comp) {
                $datosCom[$i]['product_id'] = $comp->product_id;
                $datosCom[$i]['name'] = $comp->product->product_description;
                $datosCom[$i]['unit_id'] = $comp->unit_id;
                $datosCom[$i]['quantity'] = $comp->sales_details_component_quantity;
                $i++;
            }
            $components = json_encode($datosCom);
        }
        $datos['name'] = $product->product->product_description;
        $datos['image'] = Yii::app()->theme->baseUrl . '/dist/img/' . $product->product->product_image;
        $datos['product_id'] = $product->product->product_id;
        $datos['wharehouse_id'] = $product->wharehouse_id;
        $datos['quantity'] = $product->sale_details_quantity;
        $datos['unit_id'] = $product->unit_id;
        $datos['price'] = $product->sale_details_price;
        $datos['price_real'] = $product->product->product_price;
        $datos['total'] = $product->sale_details_quantity * $product->sale_details_price;
        $this->renderPartial('/products/productStoreUpdate', array('cant' => $cant, 'product' => $datos, 'tax' => $tax, 'components' => $components));
        exit;
    }

    public function actionIndexCharts($id){
        
        
        if($id == 1){
            $title = 'Pedidos';
        }
        if($id == 2){
            $title = 'Remisiones';
        }
        if($id == 3){
            $title = 'Ventas';
        }
        
        //echo $id;exit;
        $model = '';
        $this->renderPartial('/site/salesCharts',array('model'=>$model,'title'=>$title),false,true);
    }
}
