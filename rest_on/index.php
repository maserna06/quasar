<?php
date_default_timezone_set('America/Bogota');
require __DIR__.'/environment.php';

//error_reporting(E_ALL);
error_reporting(YII_DEBUG?E_ALL:0);

if(!$yii) $yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once __DIR__.'/vendor/autoload.php';

Yii::createWebApplication($config)->run();
