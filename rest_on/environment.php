<?php

/*
 *  Created by Diego Castro <diego.castro@knowbi.com>
 */

$env=false;
define('ENV_DEV','ENV_DEV');
define('ENV_LOCAL','ENV_LOCAL');
define('ENV_PRODUCTION','ENV_PRODUCTION');
$stackTraceLevel=3;
$debug=false;
$yii=false;

if(in_array($_SERVER['HTTP_HOST'],['diarcastro.local'])){
  $env=ENV_LOCAL;
  $yii=dirname(__FILE__).'/../../yii/framework/yii.php';
  $debug=true;
}

defined('YII_DEBUG') or define('YII_DEBUG',$debug);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',$stackTraceLevel);

define('YII_ENV',$env);
