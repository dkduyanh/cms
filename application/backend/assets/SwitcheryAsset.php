<?php

namespace backend\assets;

use yii\web\AssetBundle;

class SwitcheryAsset extends AssetBundle
{
    public $sourcePath = 'vendor/switchery';
    public $css = [
        'dist/switchery.min.css'
    ];
    public $js = [
        'dist/switchery.min.js',
    ];
    public $publishOptions = [
        'only' => [
            'dist/*'
        ],
    ];
}