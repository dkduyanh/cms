<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%text_source}}".
 *
 * @property string $id
 * @property string $category Specifies the name of translation sets
 * @property string $message The message that needs to be translated
 *
 * @property TextTranslation[] $textTranslations
 * @property Languages[] $languages
 */
class TblTextSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%text_source}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 64],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTextTranslations()
    {
        return $this->hasMany(TextTranslation::className(), ['source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Languages::className(), ['code' => 'language'])->viaTable('{{%text_translation}}', ['source_id' => 'id']);
    }
}
