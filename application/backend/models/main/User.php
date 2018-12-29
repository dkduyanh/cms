<?php

namespace backend\models\main;

use Yii;
use common\models\UserConfiguration;

class User extends \common\models\main\User
{
    public static function listTitles()
    {
        $titles = explode(',', (new UserConfiguration())->titles);
        return array_combine($titles, $titles);
    }

    public static function genderLabels()
    {
    	return [
    		self::GENDER_NOTSET => Yii::t('users', 'NOT SET'),
    		self::GENDER_MALE => Yii::t('users', 'MALE'),
		    self::GENDER_FEMALE => Yii::t('users', 'FEMALE'),
	    ];
    }
}