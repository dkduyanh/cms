<?php

namespace common\models\subscription\dao;

use Yii;

/**
 * This is the model class for table "{{%subscription_subscribers}}".
 *
 * @property string $id
 * @property string $code
 * @property string $fullname
 * @property string $email
 * @property string $created_date
 * @property string $ip_address
 * @property int $confirmed
 * @property int $status
 *
 * @property SubscriptionSubscriberList[] $subscriptionSubscriberLists
 * @property SubscriptionLists[] $lists
 */
class TblSubscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription_subscribers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['created_date'], 'safe'],
            [['confirmed', 'status'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['fullname', 'email'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 40],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('subscription/subscriber', 'ID'),
            'code' => Yii::t('subscription/subscriber', 'Code'),
            'fullname' => Yii::t('subscription/subscriber', 'Fullname'),
            'email' => Yii::t('subscription/subscriber', 'Email'),
            'created_date' => Yii::t('subscription/subscriber', 'Created Date'),
            'ip_address' => Yii::t('subscription/subscriber', 'Ip Address'),
            'confirmed' => Yii::t('subscription/subscriber', 'Confirmed'),
            'status' => Yii::t('subscription/subscriber', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptionSubscriberLists()
    {
        return $this->hasMany(SubscriptionSubscriberList::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLists()
    {
        return $this->hasMany(SubscriptionLists::className(), ['id' => 'list_id'])->viaTable('{{%subscription_subscriber_list}}', ['user_id' => 'id']);
    }
}
