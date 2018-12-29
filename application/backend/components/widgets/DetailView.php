<?php
/**
 * Created by PhpStorm.
 * User: DuyAnh
 * Date: 11/13/2017
 * Time: 4:54 PM
 */

namespace backend\components\widgets;


class DetailView extends \yii\widgets\DetailView
{
    public $template = '<tr><th style="width: 250px;" {captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>';
}