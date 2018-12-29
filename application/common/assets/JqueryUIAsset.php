<?php
namespace common\assets;

use yii\web\AssetBundle;

class JqueryUIAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';
    public $css = [
        'themes/smoothness/jquery-ui.css'
    ];
    public $js = [
        'jquery-ui.min.js',
    ];
    public $publishOptions = [
        'only' => [

        ],
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}