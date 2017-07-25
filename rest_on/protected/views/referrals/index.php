<?php
/* @var $this ReferralsController */
/* @var $dataProvider CActiveDataProvider */

use App\User\User as U;

$user=U::getInstance();
$visible=$user->isVendor;
$isAdmin=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Remision', 'url'=>array('index'), 'visible'=>$visible),
);
?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="col-xs-6">
        <div class="box box-warning">
          <div class="box-header">
            <h3 class="box-title">Remisiones <small>Pendientes</small></h3>
          </div>  
          <div class="box-body">
              
            	<div id="Referrals_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            		<div class="row">
            			<div class="col-sm-6"></div>
            			<div class="col-sm-6"></div>
            		</div>
            		<div class="row">
            			<div class="col-sm-12">
            			   <?php $this->widget('zii.widgets.grid.CGridView', array(
                          'id'=>'referrals-grid',
                          'itemsCssClass' => 'table table-bordered table-hover dataTable',
                          'htmlOptions'=>array('class' => 'col-sm-12' ),
                          'summaryText'=>'',
                                      'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
                                          'firstPageLabel' => '<<',
                                          'lastPageLabel' => '>>',
                                          'prevPageLabel' => '<',
                                          'nextPageLabel' => '>',),
                                      'pagerCssClass' => 'col-sm-12', 
                          'dataProvider'=>$model->search(),
                          'filter' => $model,
                          'columns'=>array(
                            array('name' => 'referral_id', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                            array(
                                  'name' =>'request_id',
                                  'filter' => CHtml::listData(Requests::model()->findAll('request_status=2'), 'request_id', 'request_id'),
                                  'value' =>'($data->request!=null) ? $data->request->request_id : null',
                              ),
                            array(
                                  'name' =>'customer_nit',
                                  'filter' => CHtml::listData(Customers::model()->findAll('customer_status=1'), 'customer_nit', 'customer_name'),
                                  'value' =>'($data->customerNit!=null) ? $data->customerNit->customer_firtsname : null',
                              ),
                            array(
                                  'name' =>'user_id',
                                  'filter' => CHtml::listData(User::model()->findAll('user_status=1'), 'user_id', 'user_name'),
                                  'value' =>'($data->user!=null) ? $data->user->user_name : null',
                              ),
                            'referral_date',
                            'referral_total',
                            'referral_net_worth',
                            /*array(
                                  'name' =>'accounts_id',
                                  'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
                                  'value' =>'($data->accounts!=null) ? $data->accounts->account_name : null',
                              ),
                            array(
                              'name'=>'referral_status',
                              'filter'=>array('2'=>'Descargada', '1'=>'Aprobada', '0'=>'Pendiente'),
                              'value'=>function($data){
                                    $result = '';
                                    switch($data->referral_status)
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
                            'referral_remarks',
                            */
                            array(
                              'class'=>'CButtonColumn',
                              'template' =>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                              'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                              'buttons'=>array
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
                        )); ?>
            			</div>
            		</div>
          	</div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
      <div class="col-xs-6">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Remisiones <small>Aprobadas</small></h3>
          </div>  
          <div class="box-body">
              
              <div id="Referrals_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6"></div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                     <?php $this->widget('zii.widgets.grid.CGridView', array(
                          'id'=>'referrals-grid',
                          'itemsCssClass' => 'table table-bordered table-hover dataTable',
                          'htmlOptions'=>array('class' => 'col-sm-12' ),
                          'summaryText'=>'',
                                      'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
                                          'firstPageLabel' => '<<',
                                          'lastPageLabel' => '>>',
                                          'prevPageLabel' => '<',
                                          'nextPageLabel' => '>',),
                                      'pagerCssClass' => 'col-sm-12', 
                          'dataProvider'=>$model->search(),
                          'filter' => $model,
                          'columns'=>array(
                            array('name' => 'referral_id', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                            array(
                                  'name' =>'request_id',
                                  'filter' => CHtml::listData(Requests::model()->findAll('request_status=2'), 'request_id', 'request_id'),
                                  'value' =>'($data->request!=null) ? $data->request->request_id : null',
                              ),
                            array(
                                  'name' =>'customer_nit',
                                  'filter' => CHtml::listData(Customers::model()->findAll('customer_status=1'), 'customer_nit', 'customer_name'),
                                  'value' =>'($data->customerNit!=null) ? $data->customerNit->customer_firtsname : null',
                              ),
                            array(
                                  'name' =>'user_id',
                                  'filter' => CHtml::listData(User::model()->findAll('user_status=1'), 'user_id', 'user_name'),
                                  'value' =>'($data->user!=null) ? $data->user->user_name : null',
                              ),
                            'referral_date',
                            'referral_total',
                            'referral_net_worth',
                            /*array(
                                  'name' =>'accounts_id',
                                  'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
                                  'value' =>'($data->accounts!=null) ? $data->accounts->account_name : null',
                              ),
                            array(
                              'name'=>'referral_status',
                              'filter'=>array('2'=>'Descargada', '1'=>'Aprobada', '0'=>'Pendiente'),
                              'value'=>function($data){
                                    $result = '';
                                    switch($data->referral_status)
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
                            'referral_remarks',
                            */
                            array(
                              'class'=>'CButtonColumn',
                              'template' =>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                              'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                              'buttons'=>array
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
                        )); ?>
                  </div>
                </div>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
      <div class="col-xs-6">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Remisiones <small>Facturadas</small></h3>
          </div>  
          <div class="box-body">
              
              <div id="Referrals_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6"></div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                     <?php $this->widget('zii.widgets.grid.CGridView', array(
                          'id'=>'referrals-grid',
                          'itemsCssClass' => 'table table-bordered table-hover dataTable',
                          'htmlOptions'=>array('class' => 'col-sm-12' ),
                          'summaryText'=>'',
                                      'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
                                          'firstPageLabel' => '<<',
                                          'lastPageLabel' => '>>',
                                          'prevPageLabel' => '<',
                                          'nextPageLabel' => '>',),
                                      'pagerCssClass' => 'col-sm-12', 
                          'dataProvider'=>$model->search(),
                          'filter' => $model,
                          'columns'=>array(
                            array('name' => 'referral_id', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                            array(
                                  'name' =>'request_id',
                                  'filter' => CHtml::listData(Requests::model()->findAll('request_status=2'), 'request_id', 'request_id'),
                                  'value' =>'($data->request!=null) ? $data->request->request_id : null',
                              ),
                            array(
                                  'name' =>'customer_nit',
                                  'filter' => CHtml::listData(Customers::model()->findAll('customer_status=1'), 'customer_nit', 'customer_name'),
                                  'value' =>'($data->customerNit!=null) ? $data->customerNit->customer_firtsname : null',
                              ),
                            array(
                                  'name' =>'user_id',
                                  'filter' => CHtml::listData(User::model()->findAll('user_status=1'), 'user_id', 'user_name'),
                                  'value' =>'($data->user!=null) ? $data->user->user_name : null',
                              ),
                            'referral_date',
                            'referral_total',
                            'referral_net_worth',
                            /*array(
                                  'name' =>'accounts_id',
                                  'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
                                  'value' =>'($data->accounts!=null) ? $data->accounts->account_name : null',
                              ),
                            array(
                              'name'=>'referral_status',
                              'filter'=>array('2'=>'Descargada', '1'=>'Aprobada', '0'=>'Pendiente'),
                              'value'=>function($data){
                                    $result = '';
                                    switch($data->referral_status)
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
                            'referral_remarks',
                            */
                            array(
                              'class'=>'CButtonColumn',
                              'template' =>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                              'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                              'buttons'=>array
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
                        )); ?>
                  </div>
                </div>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
      <div class="col-xs-6">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Remisiones <small>Anuladas</small></h3>
          </div>  
          <div class="box-body">
              
              <div id="Referrals_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6"></div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                     <?php $this->widget('zii.widgets.grid.CGridView', array(
                          'id'=>'referrals-grid',
                          'itemsCssClass' => 'table table-bordered table-hover dataTable',
                          'htmlOptions'=>array('class' => 'col-sm-12' ),
                          'summaryText'=>'',
                                      'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
                                          'firstPageLabel' => '<<',
                                          'lastPageLabel' => '>>',
                                          'prevPageLabel' => '<',
                                          'nextPageLabel' => '>',),
                                      'pagerCssClass' => 'col-sm-12', 
                          'dataProvider'=>$model->search(),
                          'filter' => $model,
                          'columns'=>array(
                            array('name' => 'referral_id', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                            array(
                                  'name' =>'request_id',
                                  'filter' => CHtml::listData(Requests::model()->findAll('request_status=2'), 'request_id', 'request_id'),
                                  'value' =>'($data->request!=null) ? $data->request->request_id : null',
                              ),
                            array(
                                  'name' =>'customer_nit',
                                  'filter' => CHtml::listData(Customers::model()->findAll('customer_status=1'), 'customer_nit', 'customer_name'),
                                  'value' =>'($data->customerNit!=null) ? $data->customerNit->customer_firtsname : null',
                              ),
                            array(
                                  'name' =>'user_id',
                                  'filter' => CHtml::listData(User::model()->findAll('user_status=1'), 'user_id', 'user_name'),
                                  'value' =>'($data->user!=null) ? $data->user->user_name : null',
                              ),
                            'referral_date',
                            'referral_total',
                            'referral_net_worth',
                            /*array(
                                  'name' =>'accounts_id',
                                  'filter' => CHtml::listData(Accounts::model()->findAll('account_status=1'), 'account_id', 'account_name'),
                                  'value' =>'($data->accounts!=null) ? $data->accounts->account_name : null',
                              ),
                            array(
                              'name'=>'referral_status',
                              'filter'=>array('2'=>'Descargada', '1'=>'Aprobada', '0'=>'Pendiente'),
                              'value'=>function($data){
                                    $result = '';
                                    switch($data->referral_status)
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
                            'referral_remarks',
                            */
                            array(
                              'class'=>'CButtonColumn',
                              'template' =>$isAdmin?'{view}{update}{delete}':'{view}{update}',
                              'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                              'buttons'=>array
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
                        )); ?>
                  </div>
                </div>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
