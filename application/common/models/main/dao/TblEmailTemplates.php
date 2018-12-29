<?php

namespace common\models\main\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "{{%tbl_email_templates}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $subject
 * @property string $body
 * @property string $sender_email
 * @property string $sender_name
 * @property string $created_date
 * @property integer $creator_id
 * @property string $last_modified_date
 * @property integer $last_modifier_id
 * @property integer $allow_delete
 */
class TblEmailTemplates extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'subject', 'body', 'sender_email', 'sender_name', 'created_date', 'creator_id'], 'required'],
            [['body'], 'string'],
            [['created_date', 'last_modified_date'], 'safe'],
            [['creator_id', 'last_modifier_id', 'allow_delete'], 'integer'],
            [['code', 'name', 'sender_email'], 'string', 'max' => 255],
            [['description', 'subject'], 'string', 'max' => 1024],
            [['sender_name'], 'string', 'max' => 128],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('email_template', 'ID'),
            'code' => Yii::t('email_template', 'Code'),
            'name' => Yii::t('email_template', 'Name'),
            'description' => Yii::t('email_template', 'Description'),
            'subject' => Yii::t('email_template', 'Subject'),
            'body' => Yii::t('email_template', 'Body'),
            'sender_email' => Yii::t('email_template', 'Sender Email'),
            'sender_name' => Yii::t('email_template', 'Sender Name'),
            'created_date' => Yii::t('email_template', 'Created Date'),
            'creator_id' => Yii::t('email_template', 'Creator ID'),
            'last_modified_date' => Yii::t('email_template', 'Last Modified Date'),
            'last_modifier_id' => Yii::t('email_template', 'Last Modifier ID'),
            'allow_delete' => Yii::t('email_template', 'Allow Delete'),
        ];
    }
}
