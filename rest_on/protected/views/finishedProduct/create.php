<?php
/* @var $this FinishedProductController */
/* @var $model FinishedProduct */

use App\User\User as U;

$user=U::getInstance();
$isSupervisor = $user->isSupervisor;

$this->menu=array(
	array('label'=>($isSupervisor?'Administrar':'Ver').' Productos Terminados', 'url'=>array('indexes')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model,'datos'=>$datos)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
