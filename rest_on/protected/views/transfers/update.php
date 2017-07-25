<?php
/* @var $this TransfersController */
/* @var $model Transfers */

use App\User\User as U;

$user=U::getInstance();
$visible=$user->isSupervisor;
$isSupervisor=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Traslado', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Detalle Traslado', 'url'=>array('view', 'id'=>$model->transfer_id)),
	array('label'=>($isSupervisor?'Administrar':'Ver').' Taslasdos', 'url'=>array('indexes')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<!--<div class="box-header">
	              <h3 class="box-title">Traslado <small>Actualizar Traslado de Inventario</small></h3>
	            </div>-->
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>