<?php

namespace common\models;


use yii\helpers\StringHelper;

class GeneralConfiguration extends ConfigModule
{
    protected $_module = 'general';

    public $siteLogo, $siteIcon, $siteName, $siteUrl, $siteOffline, $siteOfflineMessage, $siteCopyright;
    public $metaDescription, $metaKeywords, $metaRobots;
    public $smtpServer, $smtpPort, $smtpEncryption, $smtpAuthentication, $smtpUser, $smtpPassword;
    public $timezone, $dateFormat, $timeFormat;

    public function getAttributesMap()
    {
        return [
            'siteLogo' => 'site_logo',
            'siteIcon' => 'site_icon',
            'siteName' => 'site_name',
            'siteUrl' => 'site_url',
            'siteOffline' => 'site_offline',
            'siteOfflineMessage' => 'site_offline_message',
            'siteCopyright' => 'site_copyright',

            'metaDescription' =>  'meta.description',
            'metaKeywords' => 'meta.keywords',
            'metaRobots' => 'meta.robots',

            'smtpServer' => 'smtp.server',
            'smtpPort' => 'smtp.port',
            'smtpEncryption' => 'smtp.encryption',
            'smtpAuthentication' => 'smtp.authentication',
            'smtpUser' => 'smtp.user',
            'smtpPassword' => 'smtp.password',

            'timezone' => 'timezone',
            'dateFormat' => 'dateFormat',
            'timeFormat' => 'timeFormat'
        ];
    }
    
    public function getLogo()
    {
    	if(!empty($this->siteLogo)){
    		if(StringHelper::startsWith($this->siteLogo, '//') || StringHelper::startsWith($this->siteLogo, 'http://') || StringHelper::startsWith($this->siteLogo, 'https://')){
    			return $this->siteLogo;
    		}
    		return '@web'.'/uploads/'.$this->siteLogo;
    	}
    	return null;
    }
}