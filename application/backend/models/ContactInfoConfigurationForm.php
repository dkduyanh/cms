<?php

namespace backend\models;

use common\models\ContactInfoConfiguration;

class ContactInfoConfigurationForm extends ContactInfoConfiguration
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['headline', 'about', 'person', 'address', 'city', 'zip', 'email', 'phone', 'mobile', 'fax', 'website'], 'string'],
            ['email', 'email'],
            ['website', 'url'],
            [['socialmedia'], 'safe'],
            [['extras'], 'safe'],

            [['salesEmail', 'technicalEmail'], 'email'],
        ];
    }

    public function bindValue()
    {
        parent::bindValue();

        if(!is_array($this->socialmedia)){
            $this->socialmedia = unserialize($this->socialmedia);
        }

        //try to decode to array
        if(!empty($this->extras)){
            if(!is_array($this->extras)) {
                $this->extras = json_decode($this->extras);
            }
        }
        if(empty( $this->extras) || !is_array($this->extras)){
            $this->extras = [];
        }
    }
}