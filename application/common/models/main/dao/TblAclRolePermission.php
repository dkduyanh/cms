<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%acl_role_permission}}".
 *
 * @property string $role_id
 * @property string $permission_id
 * @property int $allow
 *
 * @property Roles $role
 * @property AclPermissions $permission
 */
class TblAclRolePermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%acl_role_permission}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => Yii::t('acl\role', 'Role ID'),
            'permission_id' => Yii::t('acl\role', 'Permission ID'),
            'allow' => Yii::t('acl\role', 'Allow'),
        ];
    }
}
