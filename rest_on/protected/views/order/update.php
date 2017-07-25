<?php
/* @var $this OrderController */
/* @var $model Order */

use App\User\User as U;

$user=U::getInstance();
$visible=$user->isSupervisor;
$isAdmin=$user->isAdmin;

$this->menu=array(
	array('label'=>'Crear Orden', 'url'=>array('index'), 'visible'=>$visible),
	array('label'=>'Detalle Orden', 'url'=>array('view', 'id'=>$model->order_id)),
	array('label'=>($isAdmin?'Administrar':'Ver').' Ordenes', 'url'=>array('indexes')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<!--<div class="box-header">
	              <h3 class="box-title">Orden <small>Actualizar Orden</small></h3>
	            </div>-->
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model,'datos' => $datos,)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>