<?php

namespace common\models;

class UserConfiguration extends ConfigModule
{
    protected $_module = 'user';

    public $titles, $passwordType, $minPasswordLength;
    public $showImage, $defaultImage;
    public $allowRegistration;
    public $allowEmailVerification, $allowEmailDomainValidation;
    public $emailDomainWhitelist, $emailDomainBlacklist;

    public function attributeHints()
    {
        return [
            'titles' => 'For users without a custom avatar of their own, you can either display a generic logo or a generated one based on their email address.',
            'allowRegistration' => 'Allow user create new account',
            'allowEmailVerification' => 'Send verification email after registration',
            'allowEmailDomainValidation' => 'Validate email domain',
            'minPasswordLength' => 'Minimum length of user\'s password',
        ];
    }

    public function getAttributesMap()
    {
        return [
            'titles' => 'titles',
            'showImage' => 'show_image',
            'defaultImage' => 'default_image',
            'passwordType' => 'password_type',
            'minPasswordLength' => 'min_password_length',
            'allowRegistration' => 'allow_registration',
            'allowEmailVerification' => 'allow_email_verification',
            'allowEmailDomainValidation' => 'allow_email_domain_validation',
            'emailDomainWhitelist' => 'email_domain_whitelist',
            'emailDomainBlacklist' => 'email_domain_blacklist',
        ];
    }
}