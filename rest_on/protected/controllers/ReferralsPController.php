<?php

class ReferralsPController extends Controller {

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
                'actions' => array('create', 'update', 'viewproducts', 'clientetax', 'detailview'),
                'roles' => array('super', 'admin', 'supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
        $datos = ReferralsPExtend::datos('tbl_referralsP');
        $datos['referralPConfig']->referralP_id = $model->referralP_consecut;
        $datos['products'] = ReferralsPExtend::productsReferral($id);

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

        $model = new ReferralsP;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ReferralsP'])) {
            $model->attributes = $_POST['ReferralsP'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->referralP_id));
                Yii::app()->user->setFlash("success", "Remision creada correctamente.");
            } else
                Yii::app()->user->setFlash("danger", "Datos de Remision vacios; campos marcados con ( * ) son obligatorios.");
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
        $datos = ReferralsPExtend::datos('tbl_referralsP');
        $datos['referralPConfig']->referralP_id = $model->referralP_consecut;
        $datos['products'] = ReferralsPExtend::productsReferral($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ReferralsP'])) {
            $model = ReferralsPExtend::saveReferral($id);
            $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Remisión # ' . $model->referralP_consecut . ' se ha actualizado.');
            Yii::app()->getSession()->add('confirmacion', json_encode($datosConf));
            $this->redirect(array('update', 'id' => $model->referralP_id));
            
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
        $model->referralP_status = 3;
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

        $model = new ReferralsP;
        $datos = ReferralsPExtend::datos('tbl_referralsP');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ReferralsP'])) {
            $model = ReferralsPExtend::saveReferral();
            if ($model->referralP_consecut) {
                $datosConf = array('estado' => 'success', 'mensaje' => 'Factura de Remisión # ' . $model->referralP_consecut . ' creada correctamente');
            }else {
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Remision vacios; campos marcados con ( * ) son obligatorios.');
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

        $model = new ReferralsP('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ReferralsP']))
            $model->attributes = $_GET['ReferralsP'];

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

        $model = new ReferralsP('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ReferralsP']))
            $model->attributes = $_GET['ReferralsP'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Referrals the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ReferralsP::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Referrals $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'referralsP-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionViewProducts() {

        $model = RequestsPExtend::viewProducts();

        $this->renderPartial('/products/viewModal', array('model' => $model), false, true);
    }

    public function actionClienteTax() {

        $id = $_POST['id'];
        $customer = Suppliers::model()->findByPk($id);
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
        $tax['des'] = ($customer->supplier_discount > 0) ? $customer->supplier_discount / 100 : $customer->supplier_discount;
        $tax = json_encode($tax);
        echo $tax;
        exit;
    }

    public function actionDetailView() {
        $id = $_GET['id_detail'];
        $cant = $_GET['cantidad'];

        $product = ReferralsPDetails::model()->findByPk($id);
        if ($product->referralP_details_price == $product->product->product_price) {
            $tax = ProductsExtend::addProdTax($product->product_id);
        }
        if ($tax > 0)
            $tax = 1 + ($tax / 100);
        else
            $tax = 1;
        $this->renderPartial('/products/prodComprasUpdate', array('cant' => $cant, 'product' => $product, 'tax' => $tax));
        exit;
    }

}
