<?php

namespace common\models\main;


use common\models\main\dao\TblAclPermissions;

class AclPermission extends TblAclPermissions
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAclRoleActions()
    {
        return $this->hasMany(AclRolePermission::className(), ['permission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['id' => 'role_id'])->viaTable('{{%acl_role_permission}}', ['permission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAclUserActions()
    {
        return $this->hasMany(AclUserPermission::className(), ['permission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%acl_user_permission}}', ['permission_id' => 'id']);
    }
}