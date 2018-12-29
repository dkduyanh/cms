<?php

namespace common\models\main;


use common\models\main\dao\TblAclUserPermission;

class AclUserPermission extends TblAclUserPermission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'permission_id', 'allow'], 'required'],
            [['user_id', 'permission_id'], 'integer'],
            [['allow'], 'string', 'max' => 1],
            [['user_id', 'permission_id'], 'unique', 'targetAttribute' => ['user_id', 'permission_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['permission_id'], 'exist', 'skipOnError' => true, 'targetClass' => AclPermission::className(), 'targetAttribute' => ['permission_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermission()
    {
        return $this->hasOne(AclPermission::className(), ['id' => 'permission_id']);
    }

    /**
     * @param int $userId UserID
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findUserPermissions($userId)
    {
        return self::find()->where(['user_id' => $userId])->all();
    }
}