<?php
/* @var $this CompaniesController */
/* @var $model Companies */

use App\User\User as U;

$user=U::getInstance();
$isSuper=$user->isSuper;
$visible=$user->isSuper;

$this->menu=array(
	array('label'=>'Crear Empresa', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Detalle Empresa', 'url'=>array('view', 'id'=>$model->company_id)),
	array('label'=>($isSuper?'Administrar':'Ver').' Empresas', 'url'=>array('index')),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Empresa <small>Actualizar Empresa</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>