<?php
/* @var $this CompaniesController */
/* @var $model Companies */

use App\User\User as U;

$user=U::getInstance();
$isSuper=$user->isSuper;
$visible=$user->isSuper;

$this->menu = array(
    array('label' => 'Ver Empresas', 'url' => array('index')),
    array('label' => 'Crear Empresa', 'url' => array('create'), 'visible' => $visible),
);
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Empresas <small>Formulario de Administracion</small></h3>
                </div>  
                <div class="box-body">            
                    <div id="Companies_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'companies-grid',
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
                                    array('name' => 'company_id', 'htmlOptions' => array('style' => 'width: 60px')),
                                    'company_name',
                                    'company_phone',
                                    'company_address',
                                    array(
                                        'name' => 'city_id',
                                        'filter' => CHtml::listData(Cities::model()->findAll('city_state=1'), 'city_id', 'city_name'),
                                        'value' => '($data->city!=null) ? $data->city->city_name : null',
                                    ),
                                    array(
                                        'name' => 'deparment_id',
                                        'filter' => CHtml::listData(Departaments::model()->findAll('deparment_state=1'), 'deparment_id', 'deparment_name'),
                                        'value' => '($data->deparment!=null) ? $data->deparment->deparment_name : null',
                                    ),
                                    array(
                                        'name' => 'company_status',
                                        'filter' => array('1' => 'Activo', '0' => 'Inactivo'),
                                        'value' => '($data->company_status=="1")?("Activo"):("Inactivo")'
                                    ),
                                    array(
                                        'class' => 'CButtonColumn',
                                        'template' => '{view}{update}{delete}',
                                        'htmlOptions' => array('style' => 'width: 10%; text-align: center;'),
                                        'buttons' => array
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
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>
<script>
    function eliminar(id){
        alert(id);
    }
</script>