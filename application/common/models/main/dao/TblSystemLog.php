<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%system_log}}".
 *
 * @property string $id
 * @property int $level [INFO, WARNING, ERROR]
 * @property string $env
 * @property string $category
 * @property double $created
 * @property string $message
 * @property string $extras
 */
class TblSystemLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%system_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'env', 'category', 'created', 'message'], 'required'],
            [['level'], 'integer'],
            [['created'], 'number'],
            [['message', 'extras'], 'string'],
            [['env', 'category'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'env' => 'Env',
            'category' => 'Category',
            'created' => 'Created',
            'message' => 'Message',
            'extras' => 'Extras',
        ];
    }
}
