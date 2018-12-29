<?php

namespace backend\models;

use common\library\Utils;
use common\models\GeneralConfiguration;

class GeneralConfigurationForm extends GeneralConfiguration
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['siteLogo', 'siteIcon', 'siteName', 'siteUrl', 'siteOffline', 'siteOfflineMessage', 'siteCopyright'], 'string'],
            [['metaDescription', 'metaKeywords', 'metaRobots'], 'string'],

            //datetime validation
            [['timezone', 'dateFormat', 'timeFormat'], 'string'],
            ['timezone', 'in', 'range' => array_keys(Utils::getTimezones())],

            //smtp validation
            [['smtpServer', 'smtpUser', 'smtpPassword'], 'string'],
            ['smtpPort', 'default', 'value' => 25],
            ['smtpPort', 'integer', 'min' => 1, 'max' => 65535],
            ['smtpEncryption', 'in', 'range' => ['', 'ssl', 'tls']],
            ['smtpAuthentication', 'integer', 'min' => 0, 'max' => 1],
        ];
    }

    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'siteOffline' => 'Select True to turn your site offline.',
            'siteOfflineMessage' => 'Message that will be displayed to guests when the site is offline.',
        ]);
    }
}