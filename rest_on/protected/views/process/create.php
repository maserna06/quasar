<?php
/* @var $this ProcessController */
/* @var $model Process */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isSupervisor;

$this->menu=array(
	array('label'=>($isAdmin?'Administrar':'Ver').' Procesos', 'url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Proceso <small>Crear Proceso</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
