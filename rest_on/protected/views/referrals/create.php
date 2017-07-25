<?php
/* @var $this ReferralsController */
/* @var $model Referrals */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isSupervisor;

$this->menu=array(
	array('label'=>($isAdmin?'Administrar':'Ver').' Remisiones', 'url'=>array('indexes')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<!--<div class="box-header">
	              <h3 class="box-title">Remision <small>Crear Remision</small></h3>
	            </div>-->
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model,'datos'=>$datos)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
