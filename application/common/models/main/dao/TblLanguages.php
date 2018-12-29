<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%languages}}".
 *
 * @property string $code
 * @property string $name
 * @property string $nativename
 * @property integer $direction
 * @property string $image
 * @property integer $is_default
 */
class TblLanguages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%languages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['is_default'], 'integer'],
            [['code'], 'string', 'max' => 8],
            [['direction'], 'string', 'max' => 3],
            [['name', 'nativename'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 255],
            [['position'], 'default', 'value' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('language', 'Code'),
            'name' => Yii::t('language', 'Name'),
            'nativename' => Yii::t('language', 'Nativename'),
            'direction' => Yii::t('language', 'Direction'),
            'image' => Yii::t('language', 'Image'),
            'is_default' => Yii::t('language', 'Default'),
        ];
    }
}
