<?php

namespace common\models\main;

use common\library\Utils;
use common\models\main\dao\TblUserData;
use common\models\main\dao\TblUsers;
use common\models\UserConfiguration;
use yii\db\Exception;
use common\library\image\LetterAvatar;

class User extends TblUsers
{
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	
    //const DEFAULT_IMAGE = USER_DEFAULT_IMAGE;

    const UPLOADS_DIR = UPLOADS_DIR.'/user/';
    const UPLOADS_URL = UPLOADS_URL.'/user/';

    const   GENDER_MALE = 1,
	        GENDER_FEMALE = 0,
	        GENDER_NOTSET = -1;

    /**
     * Get user's fullname
     * @param bool $reversed
     * @return string
     */
    public function getFullname($reversed=false)
    {
        if($reversed)
        {
            return $this->lastname.' '.$this->firstname;
        }
        return $this->firstname.' '.$this->lastname;
    }

    /**
     * Returns user image url
     * @return null|string
     */
    public function getImageUrl()
    {
        if(isset($this->image) && trim($this->image) != ''){
            return self::UPLOADS_URL.'/'.$this->image;
        }
        return null;
    }

    /**
     * Get default avatar url
     */
    public function getDefaultImage()
    {
    	$showImage = (new UserConfiguration())->showImage;
    	if(!$showImage)
	    {
	    	return null;
	    }

        //try to load user avatar
        $image = $this->getImageUrl();

        //if does not exist, generate default avatar
        if($image === null){
            $letterAvatar = new LetterAvatar();
            $letterAvatar->setLetter(substr($this->getFullname(), 0, 1));
            $letterAvatar->setShape('square');
            $letterAvatar->setSize(48);

            $hash = md5($this->id.$this->email.$this->username);
            $relPath = substr($hash, 0, 3).'/'.$hash.'.jpg';
            $absPath = self::UPLOADS_DIR.'/'.$relPath;
            if(!is_dir(dirname($absPath))){
                mkdir(dirname($absPath), 777, true);
            }

            $letterAvatar->saveAs($absPath, "image/jpeg");
            $this->image = $relPath;
            $this->save();
        }

        return $this->getImageUrl();
    }

    /**
     * Check if user is active
     * @return boolean
     */
    public function isActive(){
        return $this->status === self::STATUS_ACTIVE;    
    }
    
    /**
     * Check if the user provide password correctly
     * @param String $password: the password user provides
     * @return boolean
     */
    public function verifyPassword($password)
    {
        //return Utils::verifyHashedString($password, $this->password);

        //TEMPORARY
        if(Utils::verifyHashedString($password, $this->password)){
            //check old password
            if(strlen($this->password) < 40){
                //upgrade password
                $this->updatePassword($password);
            }
            return true;
        }
        return false;
    }

    /**
     * Sets new password
     * @param string $password
     */
    public function updatePassword($password)
    {
        //hash password
        $salt = Utils::getRandomString(8);
        $hash = Utils::hashString($password, $salt);
        //update db
        $cmd = self::getDb()->createCommand();
        $result = $cmd->update('tbl_users',[
            'password' => $hash,
            'last_password_changed_date' => Utils::getUTC(),
        ], 'id=:id', array(':id'=>$this->id))->execute();
        //TODO: UPDATE LAST CHANGED DATE
        return (bool) $result;
    }

    /**
     * Set user data
     * @param $key
     * @param $value
     * @return bool
     */
    public function setData($key, $value)
    {
        if($this->isNewRecord){
            throw new Exception('Unable to set data for user be newly created');
        }
        if($this->getData($key) === null){
            $model = new TblUserData();
        } else {
            $model = TblUserData::find()->where(['user_id' => $this->id])->one();
        }
        $model->value = $value;
        return $model->save();
    }

    /**
     * Get user data
     * @param $key
     * @return mixed
     */
    public function getData($key, $defaultValue = null)
    {
        $model = TblUserData::find()->where(['user_id' => $this->id])->one();
        if($model !== null){
            return $model->value;
        }
        return $defaultValue;
        //return $this->hasMany(TblUserData::className(), ['user_id' => 'id']);
    }

    public static function findByUsername($username)
    {
        return self::find()->where(['username' => $username])->one();
    }
    
    /**
     * Get status label
     * @return \common\models\main\string
     */
    public function getStatusLabel()
    {
    	return @self::statusLabels()[$this->status];
    }
    
    /**
     * Get list of status labels
     * @return string[]
     */
    public static function statusLabels()
    {
    	return array(
    		self::STATUS_ACTIVE => 'Active',
    		self::STATUS_INACTIVE => 'Inactive',
    	);
    			
    }

    public function getVerifiedStatusLabel()
    {
        return $this->verified ? \Yii::t('common', 'YES') : \Yii::t('common', 'NO');
    }

    public function getRoles()
    {
    	return $this->hasMany(Role::class, ['id' => 'role_id'])->viaTable('tbl_user_role', ['user_id' => 'id']);
    }
}