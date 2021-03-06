<?php
/* @var $this FinishedProductController */
/* @var $model FinishedProduct */

use App\User\User as U;

$user=U::getInstance();
$visible=$user->isSupervisor;
$isSupervisor=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Producto Terminado', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Detalle Producto Terminado', 'url'=>array('view', 'id'=>$model->finished_product_id)),
	array('label'=>($isSupervisor?'Administrar':'Ver').' Productos Terminados', 'url'=>array('indexes')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Producto Terminado <small>Actualizar Producto Terminado</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model,'datos'=>$datos)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>