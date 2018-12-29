<?php

namespace common\models\main;


use common\models\main\dao\TblTextSource;

class TextSource extends TblTextSource
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 50],
        ];
    }

    /**
     * Get text translations
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(TextTranslation::className(), ['source_id' => 'id']);
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        $translations = $this->getTranslations()->all();
        foreach($translations as $tran){
            $tran->delete();
        }
        return parent::beforeDelete();
    }
}