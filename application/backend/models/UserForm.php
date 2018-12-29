<?php

namespace backend\models;

use backend\models\main\User;

class UserForm extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['gender', 'birthplace', 'creator_id', 'last_modifier_id', 'verified', 'status'], 'integer'],
            [['birthdate', 'created_date', 'last_modified_date', 'last_password_changed_date', 'last_login_date', 'last_access_date', 'last_verified_date'], 'safe'],
            [['about_me', 'settings'], 'string'],
            [['code', 'email', 'image', 'title'], 'string', 'max' => 255],
            [['username', 'phone'], 'string', 'max' => 50],
            [['password', 'firstname', 'lastname'], 'string', 'max' => 128],
            [['fullname', 'displayname'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 1024],
            [['timezone'], 'string', 'max' => 32],
            [['language'], 'string', 'max' => 12],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['code'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            //['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
}