<?php
/* @var $this ProductsController */
/* @var $model Products */

use App\User\User as U;

/* @var $this ProductsController */
/* @var $dataProvider CActiveDataProvider */

$user=U::getInstance();
$visible=$user->isSupervisor;
$isAdmin=$user->isAdmin;

$this->menu=array(
	array('label'=>($isAdmin?'Administrar':'Ver').' Producto','url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Producto <small>Crear Producto</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
