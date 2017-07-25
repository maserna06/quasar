<?php
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */

use App\User\User as U;

$user=U::getInstance();
$visible=$user->isSupervisor;
$isSupervisor = $user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Traslado', 'url'=>array('create'), 'visible'=>$visible),
);
?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="col-xs-6">
        <div class="box box-warning">
          <div class="box-header">
            <h3 class="box-title">Traslados <small>Pendientes</small></h3>
          </div>  
          <div class="box-body">
              
            	<div id="Transfers_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            		<div class="row">
            			<div class="col-sm-6"></div>
            			<div class="col-sm-6"></div>
            		</div>
            		<div class="row">
            			<div class="col-sm-12">
            			   <?php $this->widget('zii.widgets.grid.CGridView', array(
                          'id'=>'transfers-grid',
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
                            array('name' => 'transfer_consecut', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                            array(
                                  'name' =>'user_id',
                                  'filter' => CHtml::listData(User::model()->findAll('user_status=1'), 'user_id', 'user_name'),
                                  'value' =>'($data->user!=null) ? $data->user->user_name : null',
                              ),
                            'transfer_date',
                            //'transfer_remarks',
                            /*array(
                              'name'=>'transfer_status',
                              'filter'=>array('1'=>'Realizado','0'=>'Pendiente'),
                              'value'=>function($data){
                                      $result = '';
                                      switch($data->transfer_status)
                                      {
                                         case '1':
                                              $result = 'Realizado';
                                          break;
                                          case '0':
                                              $result = 'Pendiente';
                                          break;
                                      }
                                      return $result;
                                  },
                            ),*/
                            array(
                              'class'=>'CButtonColumn',
                              'template' =>$isSupervisor?'{view}{delete}':'{view}',
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
            <h3 class="box-title">Traslados <small>Realizados</small></h3>
          </div>  
          <div class="box-body">
              
              <div id="Transfers_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6"></div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                     <?php $this->widget('zii.widgets.grid.CGridView', array(
                          'id'=>'transfers-grid',
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
                            array('name' => 'transfer_consecut', 'htmlOptions' => array('style' => 'width: 60px !important;')),
                            array(
                                  'name' =>'user_id',
                                  'filter' => CHtml::listData(User::model()->findAll('user_status=1'), 'user_id', 'user_name'),
                                  'value' =>'($data->user!=null) ? $data->user->user_name : null',
                              ),
                            'transfer_date',
                            //'transfer_remarks',
                            /*array(
                              'name'=>'transfer_status',
                              'filter'=>array('1'=>'Realizado','0'=>'Pendiente'),
                              'value'=>function($data){
                                      $result = '';
                                      switch($data->transfer_status)
                                      {
                                         case '1':
                                              $result = 'Realizado';
                                          break;
                                          case '0':
                                              $result = 'Pendiente';
                                          break;
                                      }
                                      return $result;
                                  },
                            ),*/
                            array(
                              'class'=>'CButtonColumn',
                              'template' =>$isSupervisor?'{view}{delete}':'{view}',
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
