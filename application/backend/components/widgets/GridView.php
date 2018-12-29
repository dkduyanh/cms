<?php

namespace backend\components\widgets;

class GridView extends \yii\grid\GridView
{
    public $tableOptions = [
        'class' => 'table table-bordered table-hover'
    ];
}