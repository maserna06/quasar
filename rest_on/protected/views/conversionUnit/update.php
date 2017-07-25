<?php
/* @var $this ConversionUnitController */
/* @var $model ConversionUnit */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Conversion de Unidad', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>($isAdmin?'Administrar':'Ver').' Conversion de Unidades','url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Conversion de Unidad <small>Actualizar Conversion de Unidad</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>