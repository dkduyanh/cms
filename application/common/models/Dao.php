<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

abstract class Dao extends \yii\db\ActiveRecord
{
    public static function tablePrefix()
    {
        return Yii::$app->db->tablePrefix;
    }

    public static function getDb()
    {
        return Yii::$app->db;
    }

    public static function getFromCache($key)
    {
        return Yii::$app->cache->get($key);
    }

    public static function setCache($key, $value, $duration = null, $dependency = null)
    {
        Yii::$app->cache->set($key, $value, $duration, $dependency);
    }

    public static function deleteCache($key)
    {
        Yii::$app->cache->delete($key);
    }

    public static function invalidateCacheDependency($tags)
    {
        TagDependency::invalidate(Yii::$app->cache, $tags);
    }
}