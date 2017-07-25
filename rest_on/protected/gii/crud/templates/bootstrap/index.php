<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

$visible = 0;

//Validate Visibility
if(Yii::app()->user->checkAccess("super") || Yii::app()->user->checkAccess("admin"))
  $visible = 1;

$this->menu=array(
	array('label'=>'Crear <?php echo $this->modelClass; ?>', 'url'=>array('create'), 'visible'=>$visible),
	array('label'=>'Administrar <?php echo $this->modelClass; ?>', 'url'=>array('admin'), 'visible'=>$visible),
);
?>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title"><?php echo $this->getModelClass(); ?> <small>Informaciòn General</small></h3>
        </div>  
        <div class="box-body">
            
          	<div id="<?php echo $this->getModelClass(); ?>_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          		<div class="row">
          			<div class="col-sm-6"></div>
          			<div class="col-sm-6"></div>
          		</div>
          		<div class="row">
          			<div class="col-sm-12">
          				<table id="<?php echo $this->getModelClass(); ?>" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="<?php echo $this->getModelClass(); ?>_info">
                        <!--<thead>
                        	<tr role="row">
                        		<th class="sorting_asc" tabindex="0" aria-controls="<?php echo $this->getModelClass(); ?>" rowspan="1" colspan="1" aria-sort="ascending">ID</th>
                        		<th class="sorting" tabindex="0" aria-controls="<?php echo $this->getModelClass(); ?>" rowspan="1" colspan="1">Usuario</th> 
                        	</tr>
                        </thead>-->
                        <tbody>
          							<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
          								'dataProvider'=>$dataProvider,
          								'itemView'=>'_view',
          								'id'=>'<?php echo $this->getModelClass(); ?>-table',
                          'summaryText'=>'',
                          'pager'=>array('htmlOptions'=>array('class'=>'pagination pull-right'),
                                'firstPageLabel' => '<<',
                                'lastPageLabel' => '>>',
                                'prevPageLabel' => '<',
                                'nextPageLabel' => '>',),
                          'pagerCssClass' => 'col-sm-12',
          							)); ?>
          						</tbody>
                        <!--<tfoot>
                        	<tr>
                        		<th rowspan="1" colspan="1">ID</th>
                        		<th rowspan="1" colspan="1">Usuario</th>
                        	</tr>
                        </tfoot>-->
                      </table>
          			</div>
          		</div>
        	</div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
