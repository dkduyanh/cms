<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%acl_user_permission}}".
 *
 * @property string $user_id
 * @property string $permission_id
 * @property int $allow
 *
 * @property Users $user
 * @property AclPermissions $permission
 */
class TblAclUserPermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%acl_user_permission}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('acl\user', 'User ID'),
            'permission_id' => Yii::t('acl\user', 'Permission ID'),
            'allow' => Yii::t('acl\user', 'Allow'),
        ];
    }

}
