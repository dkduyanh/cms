<?php

namespace backend\assets;

class BootstrapAsset extends \yii\bootstrap\BootstrapAsset
{
    public $css = [
        'css/bootstrap.min.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}