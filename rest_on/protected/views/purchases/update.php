<?php
/* @var $this PurchasesController */
/* @var $model Purchases */

use App\User\User as U;

$user=U::getInstance();
$visible=$user->isSupervisor;
$isAdmin=$user->isAdmin;

$this->menu=array(
	array('label'=>'Crear Compra', 'url'=>array('index'), 'visible'=>$visible),
	array('label'=>'Detalle Compra', 'url'=>array('view', 'id'=>$model->purchase_id)),
	array('label'=>($isAdmin?'Administrar':'Ver').' Compras', 'url'=>array('indexes')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<!--<div class="box-header">
	              <h3 class="box-title">Compra <small>Actualizar Compra</small></h3>
	            </div>-->
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model' => $model,'datos' => $datos,)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>