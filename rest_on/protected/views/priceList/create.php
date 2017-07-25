<?php
/* @var $this PriceListController */
/* @var $model PriceList */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin") || Yii::app()->user->checkAccess("supervisor"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Ver Lista de Precios', 'url'=>array('index')),
	array('label'=>'Administrar Lista de Precios', 'url'=>array('admin'), 'visible'=>$visible),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Lista de Precio <small>Crear Lista de Precio</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
