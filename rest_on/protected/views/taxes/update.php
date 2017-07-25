<?php
/* @var $this TaxesController */
/* @var $model Taxes */

use App\User\User as U;
$user=U::getInstance();
$isAdmin=$user->isAdmin;
$visible=$user->isAdmin;

$this->menu=array(
	array('label'=>'Crear Impuesto', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>($isAdmin?'Administrar':'Ver').' Impuestos', 'url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Impuesto <small>Actualizar Impuesto</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>	
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>