<?php
/* @var $this WharehousesController */
/* @var $model Wharehouses */

use App\User\User as U;
$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isAdmin;

$this->menu=array(
	array('label'=>'Crear Bodega', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Detalle Bodega', 'url'=>array('view', 'id'=>$model->wharehouse_id)),
	array('label'=>($isAdmin?'Administrar':'Ver').' Bodegas', 'url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Bodega <small>Actualizar Bodega</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>