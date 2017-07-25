<?php
/* @var $this UserController */
/* @var $model User */

use App\User\User as U;

$user=U::getInstance();
$isAdmin=$user->isAdmin;

$this->menu=array(
  array('label'=>($isAdmin?'Administrar':'Ver').' Usuarios', 'url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Usuario <small>Crear Usuario</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
