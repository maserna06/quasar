<?php
use App\User\User as U;

/* @var $this CustomersController */
/* @var $model Customers */
$user=U::getInstance();
$visible=$user->isSupervisor;
$isAdmin=$user->isAdmin;

$this->menu=array(
	array('label'=>'Crear Cliente', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Detalle Cliente', 'url'=>array('view', 'id'=>$model->customer_nit)),
	array('label'=>($isAdmin?'Administrar':'Ver').' Clientes','url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Cliente <small>Actualizar Cliente</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>