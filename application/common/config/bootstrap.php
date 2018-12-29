<?php
require __DIR__ . '/defines.php';

defined('YII_DEBUG') or define('YII_DEBUG', DEBUG);
defined('YII_ENV') or define('YII_ENV', ENV);

require VENDOR . '/autoload.php';
require VENDOR . '/yiisoft/yii2/Yii.php';

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

//Sets the default timezone used by all date/time functions in a script
date_default_timezone_set(DEFAULT_TIMEZONE);

#Ensure libraries/ is on include_path
set_include_path(implode(PS, array(realpath(VENDOR), get_include_path())));


function o($var = null){
    v($var); die;
}

function v($var = null){
    if($var === null) $var = 'go here';
    echo '<pre>'; var_dump($var); echo '</pre>';
}

