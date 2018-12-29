<?php

namespace common\models\subscription\dao;

use Yii;

/**
 * This is the model class for table "{{%subscription_lists}}".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $color
 * @property string $created_date
 * @property int $creator_id
 * @property string $last_modified_date
 * @property int $last_modifier_id
 * @property int $position
 * @property int $status
 *
 * @property SubscriptionMailList[] $subscriptionMailLists
 * @property SubscriptionMails[] $mails
 * @property SubscriptionSubscriberList[] $subscriptionSubscriberLists
 * @property SubscriptionSubscribers[] $users
 */
class TblList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription_lists}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_date', 'last_modified_date'], 'safe'],
            [['creator_id', 'last_modifier_id', 'position', 'status'], 'integer'],
            [['name', 'image', 'color'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('subscription/list', 'ID'),
            'name' => Yii::t('subscription/list', 'Name'),
            'description' => Yii::t('subscription/list', 'Description'),
            'image' => Yii::t('subscription/list', 'Image'),
            'color' => Yii::t('subscription/list', 'Color'),
            'created_date' => Yii::t('subscription/list', 'Created Date'),
            'creator_id' => Yii::t('subscription/list', 'Creator ID'),
            'last_modified_date' => Yii::t('subscription/list', 'Last Modified Date'),
            'last_modifier_id' => Yii::t('subscription/list', 'Last Modifier ID'),
            'position' => Yii::t('subscription/list', 'Position'),
            'status' => Yii::t('subscription/list', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptionMailLists()
    {
        return $this->hasMany(SubscriptionMailList::className(), ['list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMails()
    {
        return $this->hasMany(SubscriptionMails::className(), ['id' => 'mail_id'])->viaTable('{{%subscription_mail_list}}', ['list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptionSubscriberLists()
    {
        return $this->hasMany(SubscriptionSubscriberList::className(), ['list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(SubscriptionSubscribers::className(), ['id' => 'user_id'])->viaTable('{{%subscription_subscriber_list}}', ['list_id' => 'id']);
    }
}
