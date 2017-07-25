<?php
/* @var $this PriceListController */
/* @var $dataProvider CActiveDataProvider */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin") || Yii::app()->user->checkAccess("supervisor"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Crear Lista de Precio', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Administrar Lista de Precios', 'url'=>array('admin'), 'visible'=>$visible),
);
?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Lista de Precios <small>Informaciòn General</small></h3>
        </div>  
        <div class="box-body">
            
          	<div id="PriceList_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          		<div class="row">
          			<div class="col-sm-6"></div>
          			<div class="col-sm-6"></div>
          		</div>
          		<div class="row">
          			<div class="col-sm-12">
          				<?php $this->widget('zii.widgets.grid.CGridView', array(
                      'id'=>'price-list-grid',
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
                        /*array(
                            'header'=>'Ver',
                            'class' => 'CButtonColumn',
                            'template' => '{view}',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'buttons' => array(
                                'view' => array
                                    (
                                    'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
                                    'label' => '<i class="fa fa-eye" style="margin: 5px;"></i>',
                                    'imageUrl' => false,
                                ),
                            ),
                        ),*/
                        //'price_id',
                        array(
                          'name'=>'price_type',
                          'filter'=>array('1'=>'Compras','2'=>'Ventas'),
                          'value'=>'($data->price_type=="1")?("Compras"):("Ventas")'
                        ),
                        'price_name',
                        'price_description',
                        array(
                          'name'=>'price_status',
                          'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
                          'value'=>'($data->price_status=="1")?("Activo"):("Inactivo")'
                        ),
                      ),
                    )); ?>
          			</div>
          		</div>
        	</div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
