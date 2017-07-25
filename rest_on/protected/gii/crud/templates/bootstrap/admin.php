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
	array('label'=>'Crear <?php echo $this->modelClass; ?>', 'url'=>array('create'), 'visible'=>$visible),
);

?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title"><?php echo $this->getModelClass(); ?> <small>Formulario de Administracion</small></h3>
        </div>  
        <div class="box-body">            
          	<div id="<?php echo $this->getModelClass(); ?>_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          		<div class="row">
          			<div class="col-sm-6"></div>
          			<div class="col-sm-6"></div>
          		</div>
          		<div class="row">
					<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
						'itemsCssClass' => 'table table-bordered table-hover dataTable',
						'htmlOptions'=>array('class' => 'col-sm-12' ),
						'summaryText'=>'',
                        'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
                            'firstPageLabel' => '<<',
                            'lastPageLabel' => '>>',
                            'prevPageLabel' => '<',
                            'nextPageLabel' => '>',),
                        'pagerCssClass' => 'col-sm-12', 
						'dataProvider'=>$model->search(),
						'columns'=>array(
					<?php
					$count=0;
					foreach($this->tableSchema->columns as $column)
					{
						if(++$count==7)
							echo "\t\t/*\n";
						echo "\t\t'".$column->name."',\n";
					}
					if($count>=7)
						echo "\t\t*/\n";
					?>
							array(
								'class'=>'CButtonColumn',
								'template'=>'{view}{update}{delete}',
								'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
								'buttons'=>array
							    (
							        'view' => array
							        (
							            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
						                'label' => '<i class="fa fa-eye" style="margin: 5px;"></i>',
						                'imageUrl' => false,
							        ),
							        'update' => array
							        (
							            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Actualizar"),
						                'label' => '<i class="fa fa-pencil" style="margin: 5px;"></i>',
						                'imageUrl' => false,
							        ),
							        'delete' => array
							        (
							            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
						                'label' => '<i class="fa fa-times" style="margin: 5px;"></i>',
						                'imageUrl' => false,
							        ),
							    ),
							),
						),
					)); ?>
				</div>
        	</div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
