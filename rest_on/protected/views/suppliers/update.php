<?php
/* @var $this SuppliersController */
/* @var $model CompaniesSuppliers */

use App\User\User as U;
$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isSupervisor;

$this->menu=array(
	array('label'=>'Crear Proveedor', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Detalle Proveedor', 'url'=>array('view', 'id'=>$model->supplier_nit)),
	array('label'=>($isAdmin?'Administrar':'Ver').' Proveedores','url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Proveedor <small>Actualizar Proveedor</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>