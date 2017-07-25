<?php
/* @var $this ClassificationController */
/* @var $dataProvider CActiveDataProvider */

use App\User\User as U;

$user = U::getInstance();
$isAdmin = $user->isAdmin;
$visible = $user->isSupervisor;

$this->menu = array(
    array('label' => 'Crear Clasificacion', 'url' => array('create'), 'visible' => $visible),
);
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Clasificaciones <small>Informaciòn General</small></h3>
                </div>  
                <div class="box-body">

                    <div id="Classification_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'classification-grid',
                                    'itemsCssClass' => 'table table-bordered table-hover dataTable',
                                    'htmlOptions' => array('class' => 'col-sm-12'),
                                    'summaryText' => '',
                                    'pager' => array('htmlOptions' => array('class' => 'pagination pull-right'),
                                        'firstPageLabel' => '<<',
                                        'lastPageLabel' => '>>',
                                        'prevPageLabel' => '<',
                                        'nextPageLabel' => '>',),
                                    'pagerCssClass' => 'col-sm-12',
                                    'dataProvider' => $model->search(),
                                    'filter' => $model,
                                    'columns' => array(
                                        //'classification_id',
                                        'classification_name',
                                        'classification_description',
                                        array(
                                            'name' => 'classification_status',
                                            'filter' => array('1' => 'Activo', '0' => 'Inactivo'),
                                            'value' => '($data->classification_status=="1")?("Activo"):("Inactivo")'
                                        ),
                                        array(
                                            'class' => 'CButtonColumn',
                                            'template' => $isAdmin ? '{update}{delete}{view}' : '{update}{view}',
                                            'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                                            'buttons' => array
                                                (
                                                /* 'view' => array
                                                  (
                                                  'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Ver"),
                                                  'label' => '<i class="fa fa-eye" style="margin: 5px;"></i>',
                                                  'imageUrl' => false,
                                                  ), */
                                                'update' => array
                                                    (
                                                    'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Actualizar"),
                                                    'label' => '<i class="fa fa-pencil" style="margin: 5px;"></i>',
                                                    'imageUrl' => false,
                                                ),
                                                'delete' => array
                                                    (
                                                    'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Eliminar"),
                                                    'label' => '<i class="fa fa-times" style="margin: 5px;"></i>',
                                                    'imageUrl' => false,
                                                ),
                                                'view' => array(
                                                    'label' => '<i class="fa fa-eye"></i> ',
                                                    'imageUrl' => False,
                                                    'url' => 'Yii::app()->controller->createUrl("wharehouse", array("id" => $data->primaryKey))',
                                                    'options' => array(
                                                        'title' => 'Bodegas',
                                                        'data-toggle' => 'tooltip',
                                                        'ajax' => array(
                                                            'type' => 'get',
                                                            'url' => 'js:$(this).attr("href")',
                                                            'beforeSend' => 'function(){ $("#div-content").addClass("loadingwait"); }',
                                                            'complete' => 'function(){ $("#div-content").removeClass("loadingwait"); }',
                                                            'success' => 'function(data) { $("#bodyArchivos").html(data); $(".modal-title").html("Bodegas"); $("#myModal").modal({keyboard: false}); }'
                                                        ),
                                                    )
                                                ),
                                            ),
                                        ),
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>
<?php $this->renderPartial('../_modal'); ?>
