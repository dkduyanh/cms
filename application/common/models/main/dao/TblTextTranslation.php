<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%text_translation}}".
 *
 * @property string $source_id
 * @property string $language Specifies the language for translation
 * @property string $translation The phrase or text that is translated from source
 *
 * @property TextSource $source
 * @property Languages $language0
 */
class TblTextTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%text_translation}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['language', 'translation'], 'required'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 8],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => TextSource::className(), 'targetAttribute' => ['source_id' => 'id']],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['language' => 'code']],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'source_id' => 'Source ID',
            'language' => 'Language',
            'translation' => 'Translation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(TextSource::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(Languages::className(), ['code' => 'language']);
    }
}
