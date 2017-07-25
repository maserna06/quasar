<?php

use App\Utils\JsonResponse;
use App\User\User as U;
use App\Utils\Purifier;

class ProductsController extends Controller {

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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'create', 'update', 'autocomplete', 'productselect', 'taxes', 'components', 'cargarcomp', 'autoorder', 'autorequest', 'productview', 'productstore','productfinish','autoall','producttransfer'),
                'roles' => array('super', 'admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'autocomplete', 'productselect', 'taxes', 'components', 'cargarcomp', 'autoorder', 'autorequest', 'productview', 'productstore','autofinish'),
                'roles' => array('supervisor'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('autorequest', 'productview', 'productstore','autofinish','productfinish'),
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
        //Validate Login
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));
        $format = Yii::app()->request->getParam('format');
        //Create Extends Models
        $taxes = ProductsExtend::taxesProd($id);
        $comp = new ComponentsExtend('search');
        $visible = Components::model()->findAll('base_product_id =' . $id);
        $visible = ($visible) ? true : false;

        $model = $this->loadModel($id);

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
        //Render View
        $this->render('view', array(
            'model' => $model,
            'taxes' => $taxes,
            'comp' => $comp,
            'compVis' => $visible,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new Products;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Products'])) {

            $model = ProductsExtend::newProduct();
            if(!$model->getErrors())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Producto creado con exito.');
            else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Producto vacios; campos marcados con ( * ) son obligatorios.');
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

        if (isset($_POST['Products'])) {
            $model = ProductsExtend::newProduct($id);
            if(!$model->getErrors())
                $datosConf = array('estado' => 'success', 'mensaje' => 'Producto actualizado con exito.');
            else
                $datosConf = array('estado' => 'danger', 'mensaje' => 'Datos de Producto vacios; campos marcados con ( * ) son obligatorios.');
            
            $model->attributes = $_POST['Products'];

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

        //Delete ClassificationProduct
        if ($classProduct = ClassificationProduct::model()->findAll('product_id = ' . $model->product_id))
            ClassificationProduct::model()->deleteAll('product_id = ' . $model->product_id);

        //Delete Components
        if ($component = Components::model()->findAll('product_id = ' . $model->product_id))
            Components::model()->deleteAll('product_id = ' . $model->product_id);

        //Delete PriceList x Product
        if ($list = ProductList::model()->findAll('product_id = ' . $model->product_id))
            ProductList::model()->deleteAll('product_id = ' . $model->product_id);

        //Delete TaxProduct
        if ($tax = TaxProduct::model()->findAll('product_id = ' . $model->product_id))
            TaxProduct::model()->deleteAll('product_id = ' . $model->product_id);

        $model->product_status = 3;
        $model->save();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //ssecho '<pre>';print_r(User::model()->findByPk(YII::app()->user->id));exit;
        if (Yii::app()->user->getId() === null)
            $this->redirect(array('site/login'));

        $model = new ProductsExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductsExtend']))
            $model->attributes = $_GET['ProductsExtend'];

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

        $model = new ProductsExtend('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductsExtend']))
            $model->attributes = $_GET['ProductsExtend'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Products the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Products::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Products $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        //echo 'si cae';exit;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'products-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAutocomplete() {
        $user = U::getInstance();
        //TODO: Corregir esta parte para retorno json también
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            $term = strtoupper($term);
            $query = Yii::app()->db->createCommand();
            $query->select([
                        'product_id',
                        'product_description AS product_name',
                        'unit_id AS unit_id',
                    ])->from('tbl_products')
                    ->andWhere('product_description LIKE :name', [':name' => '%' . $term . '%'])
                    ->andWhere('product_status = 1')
                    ->andWhere('company_id = '.Yii::app()->getSession()->get('empresa'));
            if (!$user->isSuper) {
                $query->andWhere('company_id=:company_id', [':company_id' => $user->companyId]);
            }
            $res = $query->queryAll();
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }

    public function actionProductSelect() {
        $id = $_GET['id_prod'];
        $cant = $_GET['cantidad'];
        $baseId = $_GET['id'];
        $existe = Components::model()->findByAttributes(array('base_product_id' => $baseId, 'product_id' => $id));
        if ($id != $baseId) {
            $product = Products::model()->findByPk($id);
            if ($product && $product->product_status == 1) {
                $data = '<td><div id="producto' . $cant . '">' . $product->product_description . '</div><input type="hidden" name="component[' . $cant . '][prod]" id="prod_' . $cant . '" value="' . $id . '"></td>';
                $data .= '<td>';
                $data .= CHtml::dropDownList('component[' . $cant . '][und]', '', CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name'), array('empty' => '...'));
                $data .= '</td>';
                $data .= '<td align="center " style="padding: 8px;"><input style="text-align: center;width: 50px;" type="text" name="component[' . $cant . '][cant]" id="cant' . $cant . '" value="" size="4"></td>';
                $data .= '<td align="center"><a href="#" onclick="BorrarCampo(' . $cant . ')"><i class="fa fa-times"></i></a></td>';

                echo $data;
            }
        }
        exit;
    }

    public function actionProductView() {

        $id = $_GET['id_prod'];
        $cant = $_GET['cantidad'];
        $product = Products::model()->findByPk($id);
        if ($product && $product->product_status == 1) {
            $tax = ProductsExtend::addProdTax($id);
            if ($tax > 0)
                $tax = 1 + ($tax / 100);
            else
                $tax = 1;
            $this->renderPartial('prodCompras', array('id' => $id, 'cant' => $cant, 'product' => $product, 'tax' => $tax));
        }
        exit;
    }

    /*
     * Funcion para cargar producto de autocomplete o ventana modal en punto de venta.
     */

    public function actionProductStore() {

        $id = $_GET['id_prod'];
        $cant = $_GET['cantidad'];
        $product = Products::model()->findByPk($id);
        $components = NULL;
        if ($product && $product->product_status == 1) {
            $tax = ProductsExtend::addProdTax($id);
            if ($tax > 0)
                $tax = 1 + ($tax / 100);
            else
                $tax = 1;
            if ($product->product_iscomponent == 1) {
                $components = Components::model()->findAllByAttributes(array('base_product_id' => $id));
                $datosCom = array();
                $i=0;
                foreach ($components as $comp){
                    $datosCom[$i]['product_id']= $comp->product_id;
                    $datosCom[$i]['name'] = $comp->product->product_description;
                    $datosCom[$i]['unit_id'] = $comp->unit_id;
                    $datosCom[$i]['quantity'] = $comp->component_amounts;
                    $i++;
                }
                $components = json_encode($datosCom);
            }
            $this->renderPartial('productStore', array('id' => $id, 'cant' => $cant, 'product' => $product, 'tax' => $tax, 'components' => $components));
        }
        exit;
    }
    
    /*
     * Funcion para cargar producto de autocomplete o ventana modal en proucto terminado.
     */

    public function actionProductFinish() {

        $id = $_GET['id_prod'];
        $cant = $_GET['cantidad'];
        $product = Products::model()->findByPk($id);
        $components = NULL;
        if ($product && $product->product_status == 1) {
            $tax = ProductsExtend::addProdTax($id);
            if ($tax > 0)
                $tax = 1 + ($tax / 100);
            else
                $tax = 1;
            if ($product->product_iscomponent == 1) {
                $components = Components::model()->findAllByAttributes(array('base_product_id' => $id));
                $datosCom = array();
                $i=0;
                foreach ($components as $comp){
                    $datosCom[$i]['product_id']= $comp->product_id;
                    $datosCom[$i]['name'] = $comp->product->product_description;
                    $datosCom[$i]['unit_id'] = $comp->unit_id;
                    $datosCom[$i]['quantity'] = $comp->component_amounts;
                    $i++;
                }
                $components = json_encode($datosCom);
            }
            $this->renderPartial('productFinish', array('id' => $id, 'cant' => $cant, 'product' => $product, 'tax' => $tax, 'components' => $components));
        }
        exit;
    }
    
    /*
     * Funcion para cargar producto de autocomplete o ventana modal en transferencia.
     */

    public function actionProductTransfer() {

        $id = $_GET['id_prod'];
        $cant = $_GET['cantidad'];
        $product = Products::model()->findByPk($id);
        $components = NULL;
        if ($product && $product->product_status == 1) {
            $tax = ProductsExtend::addProdTax($id);
            if ($tax > 0)
                $tax = 1 + ($tax / 100);
            else
                $tax = 1;
            if ($product->product_iscomponent == 1) {
                $components = Components::model()->findAllByAttributes(array('base_product_id' => $id));
                $datosCom = array();
                $i=0;
                foreach ($components as $comp){
                    $datosCom[$i]['product_id']= $comp->product_id;
                    $datosCom[$i]['name'] = $comp->product->product_description;
                    $datosCom[$i]['unit_id'] = $comp->unit_id;
                    $datosCom[$i]['quantity'] = $comp->component_amounts;
                    $i++;
                }
                $components = json_encode($datosCom);
            }
            $this->renderPartial('productTransfer', array('id' => $id, 'cant' => $cant, 'product' => $product, 'tax' => $tax, 'components' => $components));
        }
        exit;
    }

    public function actionComponents() {
        $response = JsonResponse::getInstance();
        $user = U::getInstance();
        $id = (int) Yii::app()->request->getParam('id', 0);
        $query = Yii::app()->db->createCommand();
        $query->select([
                    'p.product_description name',
                    'c.component_amounts AS quantity',
                    'c.product_id',
                    'c.unit_id',
                ])
                ->from('tbl_components c')
                ->leftJoin('tbl_products p', 'p.product_id=c.product_id')
                ->andWhere('c.base_product_id=:id', [':id' => $id])
        ;
        if (!$user->isSuper) {
            $query->andWhere('p.company_id=:company_id', ['company_id' => $user->companyId]);
        }
        $components = $query->queryAll();
        $unitsModels = Unit::model()->findAll('unit_status=1');
        $unitsRelationsModels = ConversionUnit::model()->findAll('convertion_status=1');
        $units = [];
        $unitsRelations = [];
        $units[] = [
            'id' => '',
            'name' => '...'
        ];
        if ($unitsModels) {
            foreach ($unitsModels as $unit) {
                $units[] = [
                    'id' => $unit->unit_id,
                    'name' => $unit->unit_name,
                ];
            }
        }
        if ($unitsRelationsModels) {
            foreach ($unitsRelationsModels as $unit) {
                $unitsRelations[$unit->convertion_base_unit][] = $unit->convertion_destination_unit;
            }
        }
        $template = '
          <tr>
            <td>
              <div class="product"></div>
              <input type="hidden" name="component[prod][]" class="product_id" />
            </td>
            
            <td align="center " style="padding: 8px;">
              <input style="text-align: center;width: 50px;" type="text" autocomplete="off" name="component[cant][]" class="quantity" value="" size="" />
            </td>
            
            <td class="units"></td>

            <td align="center">
              <a href="#" class="remove"><i class="fa fa-times"></i></a>
            </td>
          </tr>
        ';
        $response->set('components', $components)
                ->set('units', $units)
                ->set('unitsRelations', $unitsRelations)
                ->set('template', $template)
                ->output();

    }

    public function actionCargarComp() {
        $cantd = $_GET['id_prod'];
        $cant = $_GET['cantidad'];
        $baseId = $_GET['id'];
        $datos = Components::model()->findAll('base_product_id = ' . $baseId . ' and product_id =' . $cantd);
        $data = '';
        foreach ($datos as $dato) {
            $data .= '<td><div id="producto' . $cant . '">' . $dato->product->product_description . '</div><input type="hidden" name="component[' . $cant . '][prod]" id="prod_' . $cant . '" value="' . $dato->product_id . '"></td>';
            $data .= '<td>';
            $data .= CHtml::dropDownList('component[' . $cant . '][und]', '', CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name'), array('empty' => '...', 'options' => array($dato->unit_id => array('selected' => true))));
            $data .= '</td>';
            $data .= '<td align="center " style="padding: 8px;"><input style="text-align: center;width: 50px;" type="text" name="component[' . $cant . '][cant]" id="cant' . $cant . '" value="' . $dato->component_amounts . '" size="4"></td>';
            $data .= '<td align="center"><a href="#" onclick="BorrarCampo(' . $cant . ')"><i class="fa fa-times"></i></a></td></tr>';
            $cant++;
        }
        echo $data;
        exit;
    }

    public function actionTaxes() {

        $id = $_GET['product'];
        $tax = ProductsExtend::taxesSave();
        //Yii::app()->user->setFlash("info",$tax);

        $this->renderPartial('taxes', array(
            'model' => $this->loadModel($id),
            'taxes' => ProductsExtend::taxesProd($id),
        ));
        Yii::app()->end();
    }

    public function actionAutoOrder() {
        
        $purifier = Purifier::getInstance();
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            // test table is for the sake of this example
            $sql = "SELECT  p.product_id, p.product_description label, CONCAT(p.product_id,' - ',p.product_description) value, p.product_image icon, p.product_price precio, u.unit_name unidad
                    FROM tbl_products p
                    LEFT JOIN  tbl_classification_product i on p.product_id = i.product_id
                    inner join tbl_unit u on p.unit_id = u.unit_id
                    WHERE (LCASE(p.product_description) LIKE '%".strtolower($term)."%' and p.product_status = 1 and p.company_id =" . Yii::app()->getSession()->get('empresa')." and i.product_id IS NULL )
                    or (p.product_barCode LIKE '".$purifier->purify($term)."' and p.product_status = 1 and p.company_id =" . Yii::app()->getSession()->get('empresa')." and i.product_id IS NULL )";
            $cmd = Yii::app()->db->createCommand($sql);
            $res = $cmd->queryAll();
            for ($i = 0; $i < count($res); $i++) {
                $tax = ProductsExtend::addProdTax($res[$i]['product_id']);
                if ($tax > 0) {
                    $tax = 1 + ($tax / 100);
                    $res[$i]['precio'] = $res[$i]['precio'] * $tax;
                }
                $res[$i]['price'] = '$ ' . number_format($res[$i]['precio']);
            }
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }

    public function actionAutoRequest() {

        $purifier = Purifier::getInstance();
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            // test table is for the sake of this example


            $sql = "SELECT  p.product_id, p.product_description label, CONCAT(p.product_id,' - ',p.product_description) value, p.product_image icon, p.product_price precio
                    FROM tbl_products p
                    JOIN tbl_classification_product i on p.product_id = i.product_id
                    JOIN tbl_classification c On i.classification_id = c.classification_id
                    WHERE LCASE(p.product_description) LIKE '%".strtolower($term)."%' or p.product_barCode LIKE '".$purifier->purify($term)."' and p.product_status = 1 and p.company_id =" . Yii::app()->getSession()->get('empresa');
            $cmd = Yii::app()->db->createCommand($sql);
           // $cmd->bindValue(":name", "%" . strtolower($term) . "%", PDO::PARAM_STR);
//            echo '<pre>';
//            print_r($cmd);exit;
            $res = $cmd->queryAll();
            for ($i = 0; $i < count($res); $i++) {
                $tax = ProductsExtend::addProdTax($res[$i]['product_id']);
                if ($tax > 0) {
                    $tax = 1 + ($tax / 100);
                    $res[$i]['precio'] = $res[$i]['precio'] * $tax;
                }
                $res[$i]['price'] = '$ ' . number_format($res[$i]['precio']);
            }
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }
    
    public function actionAutoFinish() {

        $purifier = Purifier::getInstance();
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            // test table is for the sake of this example


            $sql = "SELECT  p.product_id, p.product_description label, CONCAT(p.product_id,' - ',p.product_description) value, p.product_image icon, p.product_price precio
                    FROM tbl_products p
                    WHERE (LCASE(p.product_description) LIKE '%".strtolower($term)."%' and p.product_iscomponent = 1 and p.product_status = 1 and p.company_id =" . Yii::app()->getSession()->get('empresa').") or (p.product_barCode LIKE '".$purifier->purify($term)."' and p.product_iscomponent = 1 and p.product_status = 1 and p.company_id =" . Yii::app()->getSession()->get('empresa').")";
            $cmd = Yii::app()->db->createCommand($sql);
           // $cmd->bindValue(":name", "%" . strtolower($term) . "%", PDO::PARAM_STR);
            //echo '<pre>';
            //print_r($cmd);exit;
            $res = $cmd->queryAll();
            for ($i = 0; $i < count($res); $i++) {
                $tax = ProductsExtend::addProdTax($res[$i]['product_id']);
                if ($tax > 0) {
                    $tax = 1 + ($tax / 100);
                    $res[$i]['precio'] = $res[$i]['precio'] * $tax;
                }
                $res[$i]['price'] = '$ ' . number_format($res[$i]['precio']);
            }
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }
    
    public function actionAutoAll() {

        $purifier = Purifier::getInstance();
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            // test table is for the sake of this example


            $sql = "SELECT  p.product_id, p.product_description label, CONCAT(p.product_id,' - ',p.product_description) value, p.product_image icon, p.product_price precio
                    FROM tbl_products p
                    WHERE (LCASE(p.product_description) LIKE '%".strtolower($term)."%' and p.product_status = 1 and p.company_id =" . Yii::app()->getSession()->get('empresa').") or (p.product_barCode LIKE '".$purifier->purify($term)."' and p.product_status = 1 and p.company_id =" . Yii::app()->getSession()->get('empresa').")";
            $cmd = Yii::app()->db->createCommand($sql);
           // $cmd->bindValue(":name", "%" . strtolower($term) . "%", PDO::PARAM_STR);
            //echo '<pre>';
            //print_r($cmd);exit;
            $res = $cmd->queryAll();
            for ($i = 0; $i < count($res); $i++) {
                $tax = ProductsExtend::addProdTax($res[$i]['product_id']);
                if ($tax > 0) {
                    $tax = 1 + ($tax / 100);
                    $res[$i]['precio'] = $res[$i]['precio'] * $tax;
                }
                $res[$i]['price'] = '$ ' . number_format($res[$i]['precio']);
            }
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }

}
