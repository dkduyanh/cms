<?php

namespace backend\components\helpers;


use yii\helpers\Html;

class AdminHelper
{
    public static function createLinkButton($link, $label, $icon = '', $class = '')
    {
        $label = self::faIcon($icon).$label;
        return Html::a($label, $link, ['class' => "{$class}"]);
    }
    
    public static function faIcon($name)
    {
        return Html::tag('i', '', ['class' => "fa fa-{$name}"])." ";
    }

    public static function createButton($link, $label = 'Create new', $icon = 'plus', $class = 'success')
    {
        $label = self::faIcon($icon).$label;
        return Html::a($label, $link, ['class' => "btn btn-{$class}"]);
    }

    public static function editButton($link, $label = 'Update', $icon = 'pencil', $class = 'primary')
    {
        $label = self::faIcon($icon).$label;
        return Html::a($label, $link, ['class' => "btn btn-{$class}"]);
    }

    public static function deleteButton($link, $label = 'Delete', $icon = 'trash', $class = 'danger')
    {
        $label = self::faIcon($icon).$label;
        return Html::a($label, $link, [
            'class' => "btn btn-{$class}",
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
    }

    public static function submitButton($label = 'Save', $icon = 'save', $class = 'success')
    {
        $label = self::faIcon($icon).$label;
        return Html::submitButton($label, ['class' => "btn btn-{$class}"]);
    }

    public static function submitAndNewButton()
    {

    }

    public static function cancelButton($link, $label = 'Cancel', $icon = 'times', $class = 'default')
    {
        $label = self::faIcon($icon).$label;
        return Html::a($label, $link, ['class' => "btn btn-{$class}"]);
    }

    public static function backButton($link, $label = 'Back', $icon = 'reply', $class = 'success')
    {
        $label = self::faIcon($icon).$label;
        return Html::a($label, $link, ['class' => "btn btn-{$class}"]);
    }
}