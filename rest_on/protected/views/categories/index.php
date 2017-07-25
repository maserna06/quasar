<?php
/* @var $this CategoriesController */
/* @var $dataProvider CActiveDataProvider */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Categoria', 'url'=>array('create'), 'visible'=>$visible),
);
?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Categorias <small>Informaciòn General</small></h3>
        </div>  
        <div class="box-body">
            
          	<div id="Categories_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          		<div class="row">
          			<div class="col-sm-6"></div>
          			<div class="col-sm-6"></div>
          		</div>
          		<div class="row">
          			<div class="col-sm-12">
                  <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'categories-grid',
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
                      //'category_id',
                      'category_description',
                      array(
                        'name'=>'category_status',
                        'filter'=>array('1'=>'Activo','0'=>'Inactivo'),
                        'value'=>'($data->category_status=="1")?("Activo"):("Inactivo")'
                      ),
                      array(
                        'class'=>'CButtonColumn',
                        'template'=>$isAdmin?'{update}{delete}':'{update}',
                        'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                        'buttons'=>array
                          (
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
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
