<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%acl_actions}}".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $category
 *
 * @property AclRoleAction[] $aclRoleActions
 * @property Roles[] $roles
 * @property AclUserAction[] $aclUserActions
 * @property Users[] $users
 */
class TblAclPermissions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%acl_permissions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'category'], 'required'],
            [['code', 'name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 1024],
            [['category'], 'string', 'max' => 50],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('acl', 'ID'),
            'code' => Yii::t('acl', 'Code'),
            'name' => Yii::t('acl', 'Name'),
            'description' => Yii::t('acl', 'Description'),
            'category' => Yii::t('acl', 'Category'),
        ];
    }
}
