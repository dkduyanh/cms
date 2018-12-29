<?php

namespace common\assets;

use yii\web\AssetBundle;

class MagnificPopupAsset extends AssetBundle
{
    public $sourcePath = '@bower/magnific-popup';
    public $css = [
        'dist/magnific-popup.css'
    ];
    public $js = [
        'dist/jquery.magnific-popup.min.js',
    ];
    public $publishOptions = [
        'only' => [
            'dist/*'
        ],
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}