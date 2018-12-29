<?php

namespace app\models;

use Yii;
use yii\caching\TagDependency;
use backend\models\main\Role;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\main\AclRolePermission;
use common\models\main\AclUserPermission;
use common\models\main\User;

/**
 *
 * @author DuyAnh
 *
 */
class AclPermissionAssignmentForm extends Model
{
    protected $_assignee;
    protected $_permissions = false;

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['assignedPermissions'], 'safe']
        ];
    }

    /**
     * Check if permission exits
     * @author DuyAnh
     */
    public function validatePerms()
    {
        if(!AclAction::find()->where(['id' => $this->action_id])->exists()){
            $this->addError('_permissions', 'Invalid permission id');
        }
    }

    /**
     * Set Assignee
     * @param object Role or User Instance
     * @throws \Exception
     */
    public function setAssignee($assignee)
    {
        if($assignee instanceof Role or $assignee instanceof User){
            $this->_assignee = $assignee;
        } else {
            throw new \Exception('Invalid Role');
        }
    }

    /**
     * Get role object
     * @return mixed
     */
    public function getAssignee()
    {
        return $this->_assignee;
    }

    /**
     * Load role permissions from DB
     *
     * @author DuyAnh
     */
    protected function loadfromDB()
    {
        if($this->_assignee instanceof Role){
            $this->_permissions = ArrayHelper::index(AclRolePermission::findPermissions($this->getAssignee()->id), 'permission_id');
        } else if($this->_assignee instanceof User)
        {
            $this->_permissions = ArrayHelper::index(AclUserPermission::findUserPermissions($this->getAssignee()->id), 'permission_id');
        }
        else $this->_permissions = [];
    }

    /**
     * Assign list permissions to this role
     * @param $permissions
     */
    public function setAssignedPermissions($permissions)
    {
        foreach($permissions as $id => $permission){
            if($permission instanceof AclRolePermission || $permission instanceof AclUserPermission){
                $this->_permissions[$id] = $permission;
            } elseif (is_array($permission)){
                $model = $this->getAssignedPermission($id);
                if($model !== null){
                    $model->setAttributes($permission);
                    $this->_permissions[$id] = $model;
                }
            }
        }
    }

    /**
     * Get a role permission by PermissionID
     * @param $id PermissionID
     * @return PermissionAssignment
     */
    public function getAssignedPermission($id)
    {
        //try to load from DB if not set
        if($this->_permissions === false){
            $this->loadfromDB();
        }

        if(isset($this->_permissions[$id])){
            $model = $this->_permissions[$id];
        }
        else {
            $model = null;
            if($this->_assignee instanceof Role){
                $model = new AclRolePermission();
                $model->role_id = $this->getAssignee()->id;
                $model->permission_id = $id;
            } else if($this->_assignee instanceof User){
                $model = new AclUserPermission();
                $model->user_id = $this->getAssignee()->id;
                $model->permission_id = $id;
            }
        }
        return $model;
    }

    /**
     * Get list of role permissions
     * @return array PermissionAssignment
     */
    public function getAssignedPermissions()
    {
        //try to load from DB
        if($this->_permissions === false){
            $this->loadfromDB();
        }
        return $this->_permissions;
    }

    public function deteleAllPermissions()
    {
        /*$sql = "DELETE FROM {{%acl_assignee_permission}} where role_id = :rid;";
        $cmd = Yii::$app->db->createCommand($sql);
        $cmd->bindValue('rid', $this->roleId, \PDO::PARAM_STR);
        return $cmd->execute();*/
    }

    public function save()
    {
        $this->deteleAllPermissions();
        $result = true;
        foreach($this->_permissions as $perm)
        {
            $perm->save(false);
        }

        if($result){
            //$this->clearCache();
        }
        return $result;
    }
}