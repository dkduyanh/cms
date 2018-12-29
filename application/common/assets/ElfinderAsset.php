<?php

namespace common\assets;

use yii\web\AssetBundle;

class ElfinderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/studio-42/elfinder';
    public $css = [
        'css/elfinder.min.css',
        'css/theme.css'
    ];
    public $js = [
        'js/elfinder.min.js',
        'js/i18n/elfinder.vi.js',
        //'js/extras/editors.default.js',
    ];
    public $publishOptions = [
        'only' => [
            'css/*',
            'js/*',
            'js/i18n/*',
            'js/proxy/*',
            'js/extras/*',
            'img/*',
            'sounds/*',
        ],
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\JqueryUIAsset',
    ];
}