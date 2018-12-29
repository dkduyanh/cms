<?php

namespace common\models\main;


use common\models\main\dao\TblAclRolePermission;

class AclRolePermission extends TblAclRolePermission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'permission_id', 'allow'], 'required'],
            [['role_id', 'permission_id'], 'integer'],
            [['allow'], 'string', 'max' => 1],
            [['role_id', 'permission_id'], 'unique', 'targetAttribute' => ['role_id', 'permission_id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['permission_id'], 'exist', 'skipOnError' => true, 'targetClass' => AclPermission::className(), 'targetAttribute' => ['permission_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermission()
    {
        return $this->hasOne(AclPermission::className(), ['id' => 'permission_id']);
    }

    /**
     * @param int $roleId RoleID
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findPermissions($roleId)
    {
        return self::find()->with('permission')->where(['role_id' => $roleId])->all();
    }
}