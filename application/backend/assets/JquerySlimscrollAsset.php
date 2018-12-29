<?php

namespace backend\assets;

use yii\web\AssetBundle;

class JquerySlimscrollAsset extends AssetBundle
{
    public $sourcePath = '@webroot/vendor/jquery-slimscroll';
    public $js = [
        'jquery.slimscroll.min.js',
    ];
    public $publishOptions = [
        'only' => [
            'jquery.slimscroll.min.js'
        ],
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}