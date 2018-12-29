<?php

namespace backend\assets;

use common\assets\MomentAsset;
use yii\web\AssetBundle;

class DateTimePickerAsset extends AssetBundle
{
    public $sourcePath = '@webroot/vendor/eonasdan-bootstrap-datetimepicker/build';
    public $js = [
        'js/bootstrap-datetimepicker.min.js',
    ];
    public $css = [
        'css/bootstrap-datetimepicker.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        MomentAsset::class,
    ];
}