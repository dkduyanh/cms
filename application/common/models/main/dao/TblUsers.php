<?php

namespace common\models\main\dao;

use common\models\Dao;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tbl_users}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $fullname
 * @property string $displayname
 * @property integer $gender
 * @property string $birthdate
 * @property integer $birthplace
 * @property string $image
 * @property string $title
 * @property string $about_me
 * @property string $description
 * @property integer $creator_id
 * @property string $created_date
 * @property integer $last_modifier_id
 * @property string $last_modified_date
 * @property string $last_password_changed_date
 * @property string $last_login_date
 * @property string $last_access_date
 * @property string $last_verified_date
 * @property string $timezone
 * @property string $language
 * @property integer $verified
 * @property integer $status
 * @property string $settings
 */
class TblUsers extends Dao
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }*/

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    /* public function rules()
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
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    } */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'password' => Yii::t('app', 'Password'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'fullname' => Yii::t('app', 'Fullname'),
            'displayname' => Yii::t('app', 'Displayname'),
            'gender' => Yii::t('app', 'Gender'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'birthplace' => Yii::t('app', 'Birthplace'),
            'image' => Yii::t('app', 'Image'),
            'title' => Yii::t('app', 'Title'),
            'about_me' => Yii::t('app', 'About Me'),
            'description' => Yii::t('app', 'Description'),
            'creator_id' => Yii::t('app', 'Creator ID'),
            'created_date' => Yii::t('app', 'Created Date'),
            'last_modifier_id' => Yii::t('app', 'Last Modifier ID'),
            'last_modified_date' => Yii::t('app', 'Last Modified Date'),
            'last_password_changed_date' => Yii::t('app', 'Last Password Changed Date'),
            'last_login_date' => Yii::t('app', 'Last Login Date'),
            'last_access_date' => Yii::t('app', 'Last Access Date'),
            'last_verified_date' => Yii::t('app', 'Last Verified Date'),
            'timezone' => Yii::t('app', 'Timezone'),
            'language' => Yii::t('app', 'Language'),
            'verified' => Yii::t('app', 'Verified'),
            'status' => Yii::t('app', 'Status'),
            'settings' => Yii::t('app', 'Settings'),
        ];
    }
}
