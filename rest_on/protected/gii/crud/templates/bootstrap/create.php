<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Ver <?php echo $this->modelClass; ?>', 'url'=>array('index')),
	array('label'=>'Administrar <?php echo $this->modelClass; ?>', 'url'=>array('admin'), 'visible'=>$visible),
);
?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header">
	              <h3 class="box-title"><?php echo $this->getModelClass(); ?> <small>Crear <?php echo $this->getModelClass(); ?></small></h3>
	            </div>
	            <div class="box-body">
					<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
				</div>
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section>
