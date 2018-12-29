<?php

namespace common\models;

class ContactInfoConfiguration extends ConfigModule
{
    protected $_module = 'contact_info';

    public $headline, $about;
    public $person, $address, $city, $zip, $email, $phone, $mobile, $fax, $website;
    public $socialmedia;
    public $extras;

    public $salesEmail, $technicalEmail;

    public function getAttributesMap()
    {
        return [
            'headline' => 'headline',
            'about' => 'about',
            'person' => 'person',
            'address' => 'address',
            'city' => 'city',
            'zip' => 'zip',
            'email' => 'email',
            'phone' => 'phone',
            'mobile' => 'mobile',
            'fax' => 'fax',
            'website' => 'website',
            'socialmedia' => 'socialmedia',
            'extras' => 'extras',

            'salesEmail' => 'salesEmail',
            'technicalEmail' => 'technicalEmail'
        ];
    }

    public static function listSupportedSocialMedia()
    {
        return [
            'rss',
            'twitter',
            'facebook',
            'instagram',
            'youtube',
            'linkedin',
            'pinterest',
            'instagram',
            'googleplus'
        ];
    }
}