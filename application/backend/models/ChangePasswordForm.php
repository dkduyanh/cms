<?php

namespace backend\models;

use common\models\main\User;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    protected $_user;
    public $currentPassword, $newPassword, $confirmNewPassword;

    //const SCENARIO_DEFAULT;

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'confirmNewPassword'], 'required'],
            ['currentPassword', 'verifyPassword'],
            ['newPassword', 'string', 'min'=>6, 'max'=>64],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => "New passwords don't match"],
        ];
    }

    /**
     * Verify if password is correct
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function verifyPassword($attribute, $params, $validator){
        if(!$this->_user->verifyPassword($this->$attribute)){
            $this->addError($attribute, 'Password is not correct!');
        }
    }

    /**
     * Set user object
     * @param $user
     */
    public function setUser($user)
    {
        if($user instanceof User){
            $this->_user = $user;
        }
    }

    /**
     * Get user object
     * @return object
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Perform password change
     * @return bool
     */
    public function update()
    {
        if($this->validate()){
            return $this->_user->updatePassword($this->newPassword);
        }
        return false;
    }
}