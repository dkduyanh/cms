<?php

namespace backend\assets;

use yii\web\AssetBundle;

class FastclickAsset extends AssetBundle
{
    public $sourcePath = '@webroot/vendor/fastclick';
    public $js = [
        'lib/fastclick.js',
    ];
    public $publishOptions = [
        'only' => [
            'lib/*',
        ],
    ];
}