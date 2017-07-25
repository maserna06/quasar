<?php
/* @var $this ComponentsController */
/* @var $model Components */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Ver Components', 'url'=>array('index')),
	array('label'=>'Administrar Components', 'url'=>array('admin'), 'visible'=>$visible),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title">Components <small>Crear Components</small></h3>
	            </div>
	            <div class="box-body">
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
