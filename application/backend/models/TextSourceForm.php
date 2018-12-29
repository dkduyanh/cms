<?php

namespace backend\models;


use backend\models\main\Language;
use backend\models\main\TextSource;
use backend\models\main\TextTranslation;
use yii\helpers\ArrayHelper;

class TextSourceForm extends TextSource
{
    protected $_translations;

    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 64],
            [['textTranslations'], 'safe']
        ];
    }

    public function getTextTranslations()
    {
        /*if(empty($this->_translations)){
            $this->_translations = ArrayHelper::index($this->getTranslations()->all(), 'language');
            foreach(Language::listAll() as $lang){
                if(!isset($this->_translations[$lang->code])){
                    $tran = new TextTranslation();
                    $tran->language = $lang->code;
                    $tran->source_id = $this->id;
                    $this->_translations[$lang->code] = $tran;
                }
            }
        }
        return $this->_translations;*/


       if(empty($this->_translations)){
           $this->_translations = ArrayHelper::map(parent::getTranslations()->all(), 'language', 'translation');
       }
       return $this->_translations;
    }

    /**
     * @param $tran
     */
    public function setTextTranslations(array $data)
    {
        $this->_translations = $data;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if($this->_translations)
        {
            foreach($this->_translations as $lang => $tran)
            {
                $transModel = TextTranslation::find()->where(['source_id' => $this->id, 'language' => $lang])->one();
                if($transModel == null){
                    $transModel = new TextTranslation();
                    $transModel->source_id = $this->id;
                    $transModel->language = $lang;
                }
                $transModel->translation = $tran;
                $transModel->save();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }
}