<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Ver Cuentas Contables', 'url'=>array('index')),
	array('label'=>'Administrar Cuentas Contables', 'url'=>array('admin'), 'visible'=>$visible),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Cuenta Contable 
	              <small>Crear Cuenta Contable</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
