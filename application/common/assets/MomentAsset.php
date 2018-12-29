<?php

namespace common\assets;

use yii\web\AssetBundle;

class MomentAsset extends AssetBundle
{
    public $sourcePath = '@bower/moment';
    public $js = [
        'min/moment.min.js',
    ];
}