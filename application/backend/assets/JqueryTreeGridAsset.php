<?php

namespace backend\assets;

use yii\web\AssetBundle;

class JqueryTreeGridAsset extends AssetBundle
{
    public $sourcePath = 'vendor/jquery-treegrid';
    public $css = [
        'css/jquery.treegrid.css',
    ];
    public $js = [
        'js/jquery.treegrid.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $publishOptions = [
        /*'only' => [
            'dist/*'
        ],*/
    ];
}