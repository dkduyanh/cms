<?php

namespace backend\models\main;

class SystemLog extends \common\models\main\SystemLog
{
    /**
     * Truncate all data
     * @return mixed
     */
    public static function truncate()
    {
        //delete all data
        parent::deleteAll();
        //reset auto-incremental ID
        return self::getDb()->createCommand("ALTER TABLE ".self::tableName()." AUTO_INCREMENT = 1")->execute();
    }
}