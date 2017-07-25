<?php
/* @var $this TaxesController */
/* @var $dataProvider CActiveDataProvider */

use App\User\User as U;

$user = U::getInstance();
$isAdmin = $user->isAdmin;
$visible = $user->isAdmin;

$this->menu = array(
    array('label' => 'Crear Impuesto', 'url' => array('create'), 'visible' => $visible),
);
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Impuesto <small>Informaciòn General</small></h3>
                </div>  
                <div class="box-body">

                    <div id="Taxes_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'taxes-grid',
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
                                        //array('name' => 'tax_id', 'htmlOptions' => array('style' => 'width: 60px')),
                                        'tax_description',
                                        array(
                                            'name' => 'tax_ishighervalue',
                                            'filter' => array('1' => 'Aplica', '0' => 'No Aplica'),
                                            'value' => '($data->tax_ishighervalue=="1")?("Aplica"):("No Aplica")'
                                        ),
                                        array(
                                            'name' => 'tax_islowervalue',
                                            'filter' => array('1' => 'Aplica', '0' => 'No Aplica'),
                                            'value' => '($data->tax_islowervalue=="1")?("Aplica"):("No Aplica")'
                                        ),
                                        'tax_rate',
                                        array(
                                            'name' => 'economic_activity_cod',
                                            'filter' => CHtml::listData(EconomicActivities::model()->findAll('economic_activity_status=1'), 'economic_activity_cod', 'economic_activity_description'),
                                            'value' => '($data->economicActivityCod!=null) ? $data->economicActivityCod->economic_activity_description : null',
                                            'htmlOptions' => array('style' => 'width: 200px'),
                                        ),
                                        array(
                                            'name' => 'tax_status',
                                            'filter' => array('1' => 'Activo', '0' => 'Inactivo'),
                                            'value' => '($data->tax_status=="1")?("Activo"):("Inactivo")'
                                        ),
                                        /*
                                          'tax_cta_income',
                                          'tax_cta_spending',
                                         */
                                        array(
                                            'class' => 'CButtonColumn',
                                            'template' => $isAdmin ? '{update}{delete}' : '{update}',
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
