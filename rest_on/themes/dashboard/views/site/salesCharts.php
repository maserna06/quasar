
<?php
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => array('text' => $title),
        'xAxis' => array(
            'categories' => array('Semana 1', 'Semana 2', 'Semana 3')
        ),
        'yAxis' => array(
            'title' => array('text' => 'Valor')
        ),
        'series' => array(
            array('name' => 'Vendor 1', 'data' => array(1, 0, 4)),
            array('name' => 'Vendor 2', 'data' => array(5, 7, 3))
        ),
        'chart' => array(
            'plotBackgroundColor' => '#ffffff',
            'plotBorderWidth' => null,
            'plotShadow' => false,
            'height' => 250,
        ), 
    ),
));
?>