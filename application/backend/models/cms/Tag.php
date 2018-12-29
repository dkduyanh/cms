<?php

namespace backend\models\cms;

class Tag extends \common\models\cms\Tag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
        ];
    }

    /**
     * Find tag by name
     * @param $name
     */
    public static function findByName($name)
    {
        return self::find()->where(['name' => $name])->one();
    }
}