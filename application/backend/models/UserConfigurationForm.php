<?php

namespace backend\models;

use common\models\UserConfiguration;

class UserConfigurationForm extends UserConfiguration
{
    public function rules()
    {
        return [
            [['titles', 'defaultImage', 'passwordType'], 'string'],
            [['showImage'], 'integer'],
            [['allowRegistration'], 'integer'],
            ['allowRegistration', 'default', 'value' => 1],

            ['minPasswordLength', 'integer'],
            ['minPasswordLength', 'default', 'value' => 6],
        ];
    }
}