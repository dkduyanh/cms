<?php

namespace frontend\controllers;

use common\models\GeneralConfiguration;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     *
     */
    public function init()
    {
        //check if site is under mantenance mode?
        $generalConfig = new GeneralConfiguration();
        if($generalConfig->siteOffline){
            die($generalConfig->siteOfflineMessage);
        }

        //load translation
        \Yii::$app->i18n->translations['fe'] = [
            'class' => 'common\components\i18n\DbMessageSource',
            'sourceMessageTable' => '{{%text_source}}',
            'messageTable' => '{{%text_translation}}',
            'sourceLanguage' => '',
        ];

        //load auto-loaded configurations

        //load meta tags
        if($generalConfig->metaKeywords){
            \Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $generalConfig->metaKeywords,
            ]);
        }
        if($generalConfig->metaDescription) {
            \Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $generalConfig->metaDescription,
            ]);
        }

        parent::init();
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}