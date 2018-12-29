<?php

namespace backend\models\main;

class AclPermission extends \common\models\main\AclPermission
{
    /**
     * List all permissions
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function listAll()
    {
        return self::find()->orderBy(['id' => 'asc'])->all();
    }
}