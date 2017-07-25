<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'components-grid',
    'itemsCssClass' => 'table table-bordered table-hover dataTable',
    'htmlOptions' => array('class' => 'col-sm-12'),
    'summaryText' => '',
    'pager' => array('htmlOptions' => array('class' => 'pagination pull-right'),
        'firstPageLabel' => '<<',
        'lastPageLabel' => '>>',
        'prevPageLabel' => '<',
        'nextPageLabel' => '>',),
    'pagerCssClass' => 'col-sm-12',
    'dataProvider' => $model->search($prod->product_id),
    'columns' => array(
        //array('header' => 'Id', 'value' => '$data->component_id', 'sortable' => 'true',),
        array('header' => 'Componente', 'value' => '$data->product->product_description', 'sortable' => 'true',),
        array('header' => 'Cantidad', 'value' => '$data->component_amounts', 'sortable' => 'true',),
        array('header' => 'Unidad', 'value' => '$data->unit->unit_name', 'sortable' => 'true',),
    ),
));
?>