<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%user_data}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $value
 */
class TblUserData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'user_id' => Yii::t('user', 'User ID'),
            'name' => Yii::t('user', 'Name'),
            'value' => Yii::t('user', 'Value'),
        ];
    }
}
