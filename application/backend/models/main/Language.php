<?php

namespace backend\models\main;


class Language extends \common\models\main\Language
{
    public static function directionLabels()
    {
        return [
            self::DIRECTION_LTR => 'LEFT-TO-RIGHT (LTR)',
            self::DIRECTION_RTL => 'RIGHT-TO-LEFT (RTL)',
        ];
    }
}