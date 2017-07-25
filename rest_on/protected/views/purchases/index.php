<?php
/* @var $this PurchasesController */
/* @var $dataProvider CActiveDataProvider */

use App\User\User as U;

$user=U::getInstance();
$visible=$user->isSupervisor;
$isAdmin=$user->isAdmin;

$this->menu = array(
    array('label' => 'Crear Compra', 'url' => array('index'), 'visible' => $visible),
);
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Compras <small>Pendientes</small></h3>
                    </div>  
                    <div class="box-body">

                        <div id="Purchases_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'purchases-grid',
                                        'itemsCssClass' => 'table table-bordered table-hover dataTable',
                                        'htmlOptions' => array('class' => 'col-sm-12'),
                                        'summaryText' => '',
                                        'pager' => array('htmlOptions' => array('class' => 'pagination pull-right'),
                                            'firstPageLabel' => '<<',
                                            'lastPageLabel' => '>>',
                                            'prevPageLabel' => '<',
                                            'nextPageLabel' => '>',),
                                        'pagerCssClass' => 'col-sm-12',
                                        'dataProvider' => $model->search(),
                                        'filter' => $model,
                                        'columns' => array(
                                            array('name' => 'purchase_consecut', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                                            array(
                                                'name' => 'order_id',
                                                'filter' => CHtml::listData(Order::model()->findAll('order_status=2'), 'order_id', 'order_id'),
                                                'value' => '($data->order!=null) ? $data->order->order_consecut : null',
                                            ),
                                            array(
                                                'name' => 'supplier_nit',
                                                'filter' => SuppliersExtend::supplierCompany(),
                                                'value' => '($data->supplierNit!=null) ? $data->supplierNit->supplier_name : null',
                                            ),
                                            array(
                                                'name' => 'user_id',
                                                'filter' => UserExtend::userCompany(),
                                                'value' => '($data->user!=null) ? $data->user->user_name : null',
                                            ),
                                            'purchase_date',
                                            'purchase_total',
                                            'purchase_net_worth',
                                            /*array(
                                                'name' => 'accounts_id',
                                                'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
                                                'value' => '($data->accounts!=null) ? $data->accounts->account_number : null',
                                            ),
                                            array(
                                                'name' => 'purchase_status',
                                                'filter'=>array('2'=>'Descargada', '1'=>'Aprobada', '0'=>'Pendiente'),
                                                'value'=>function($data){
                                                        $result = '';
                                                        switch($data->purchase_status)
                                                        {
                                                            case '2':
                                                                $result = 'Descargada';
                                                            break;
                                                            case '1':
                                                                $result = 'Aprobada';
                                                            break;
                                                            case '0':
                                                                $result = 'Pendiente';
                                                            break;
                                                        }
                                                        return $result;
                                                    },
                                            ),*/
                                            /*
                                              'purchase_remarks',
                                             */
                                            array(
                                                'class' => 'CButtonColumn',
                                                'template' =>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                                                'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                                                'buttons' => array
                                                    (
                                                    'view' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
                                                        'label' => '<i class="fa fa-eye" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                    'update' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Actualizar"),
                                                        'label' => '<i class="fa fa-pencil" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                    'delete' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Eliminar"),
                                                        'label' => '<i class="fa fa-times" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-xs-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Compras <small>Aprobadas</small></h3>
                    </div>  
                    <div class="box-body">

                        <div id="Purchases_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'purchases-grid',
                                        'itemsCssClass' => 'table table-bordered table-hover dataTable',
                                        'htmlOptions' => array('class' => 'col-sm-12'),
                                        'summaryText' => '',
                                        'pager' => array('htmlOptions' => array('class' => 'pagination pull-right'),
                                            'firstPageLabel' => '<<',
                                            'lastPageLabel' => '>>',
                                            'prevPageLabel' => '<',
                                            'nextPageLabel' => '>',),
                                        'pagerCssClass' => 'col-sm-12',
                                        'dataProvider' => $model->search(),
                                        'filter' => $model,
                                        'columns' => array(
                                            array('name' => 'purchase_consecut', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                                            array(
                                                'name' => 'order_id',
                                                'filter' => CHtml::listData(Order::model()->findAll('order_status=2'), 'order_id', 'order_id'),
                                                'value' => '($data->order!=null) ? $data->order->order_consecut : null',
                                            ),
                                            array(
                                                'name' => 'supplier_nit',
                                                'filter' => SuppliersExtend::supplierCompany(),
                                                'value' => '($data->supplierNit!=null) ? $data->supplierNit->supplier_name : null',
                                            ),
                                            array(
                                                'name' => 'user_id',
                                                'filter' => UserExtend::userCompany(),
                                                'value' => '($data->user!=null) ? $data->user->user_name : null',
                                            ),
                                            'purchase_date',
                                            'purchase_total',
                                            'purchase_net_worth',
                                            /*array(
                                                'name' => 'accounts_id',
                                                'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
                                                'value' => '($data->accounts!=null) ? $data->accounts->account_number : null',
                                            ),
                                            array(
                                                'name' => 'purchase_status',
                                                'filter'=>array('2'=>'Descargada', '1'=>'Aprobada', '0'=>'Pendiente'),
                                                'value'=>function($data){
                                                        $result = '';
                                                        switch($data->purchase_status)
                                                        {
                                                            case '2':
                                                                $result = 'Descargada';
                                                            break;
                                                            case '1':
                                                                $result = 'Aprobada';
                                                            break;
                                                            case '0':
                                                                $result = 'Pendiente';
                                                            break;
                                                        }
                                                        return $result;
                                                    },
                                            ),*/
                                            /*
                                              'purchase_remarks',
                                             */
                                            array(
                                                'class' => 'CButtonColumn',
                                                'template' =>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                                                'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                                                'buttons' => array
                                                    (
                                                    'view' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
                                                        'label' => '<i class="fa fa-eye" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                    'update' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Actualizar"),
                                                        'label' => '<i class="fa fa-pencil" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                    'delete' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Eliminar"),
                                                        'label' => '<i class="fa fa-times" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Compras <small>Anuladas</small></h3>
                    </div>  
                    <div class="box-body">

                        <div id="Purchases_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'purchases-grid',
                                        'itemsCssClass' => 'table table-bordered table-hover dataTable',
                                        'htmlOptions' => array('class' => 'col-sm-12'),
                                        'summaryText' => '',
                                        'pager' => array('htmlOptions' => array('class' => 'pagination pull-right'),
                                            'firstPageLabel' => '<<',
                                            'lastPageLabel' => '>>',
                                            'prevPageLabel' => '<',
                                            'nextPageLabel' => '>',),
                                        'pagerCssClass' => 'col-sm-12',
                                        'dataProvider' => $model->search(),
                                        'filter' => $model,
                                        'columns' => array(
                                            array('name' => 'purchase_consecut', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                                            array(
                                                'name' => 'order_id',
                                                'filter' => CHtml::listData(Order::model()->findAll('order_status=2'), 'order_id', 'order_id'),
                                                'value' => '($data->order!=null) ? $data->order->order_consecut : null',
                                            ),
                                            array(
                                                'name' => 'supplier_nit',
                                                'filter' => SuppliersExtend::supplierCompany(),
                                                'value' => '($data->supplierNit!=null) ? $data->supplierNit->supplier_name : null',
                                            ),
                                            array(
                                                'name' => 'user_id',
                                                'filter' => UserExtend::userCompany(),
                                                'value' => '($data->user!=null) ? $data->user->user_name : null',
                                            ),
                                            'purchase_date',
                                            'purchase_total',
                                            'purchase_net_worth',
                                            /*array(
                                                'name' => 'accounts_id',
                                                'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
                                                'value' => '($data->accounts!=null) ? $data->accounts->account_number : null',
                                            ),
                                            array(
                                                'name' => 'purchase_status',
                                                'filter'=>array('2'=>'Descargada', '1'=>'Aprobada', '0'=>'Pendiente'),
                                                'value'=>function($data){
                                                        $result = '';
                                                        switch($data->purchase_status)
                                                        {
                                                            case '2':
                                                                $result = 'Descargada';
                                                            break;
                                                            case '1':
                                                                $result = 'Aprobada';
                                                            break;
                                                            case '0':
                                                                $result = 'Pendiente';
                                                            break;
                                                        }
                                                        return $result;
                                                    },
                                            ),*/
                                            /*
                                              'purchase_remarks',
                                             */
                                            array(
                                                'class' => 'CButtonColumn',
                                                'template' =>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                                                'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                                                'buttons' => array
                                                    (
                                                    'view' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
                                                        'label' => '<i class="fa fa-eye" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                    'update' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Actualizar"),
                                                        'label' => '<i class="fa fa-pencil" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                    'delete' => array
                                                        (
                                                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Eliminar"),
                                                        'label' => '<i class="fa fa-times" style="margin: 5px;"></i>',
                                                        'imageUrl' => false,
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>
