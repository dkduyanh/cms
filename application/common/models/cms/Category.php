<?php

namespace common\models\cms;

use common\models\main\User;
use Yii;
use common\models\cms\dao\TblCmsCategories;
use yii\behaviors\SluggableBehavior;

class Category extends TblCmsCategories
{
    const   STATUS_ACTIVE = 1,
            STATUS_INACTIVE = 0;

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'code'
            ],
        ];
    }

    /**
     * Get status label
     * @return string
     */
    public function getStatusLabel()
    {
        return @self::statusLabels()[$this->status];
    }

    /**
     * Get parent info
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * Get childrens
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
    	return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastModifier()
    {
        return $this->hasOne(User::className(), ['id' => 'last_modifier_id']);
    }

    /**
     * Checks if status is active
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * List all status labels
     * @return array
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_INACTIVE => Yii::t('cms/post', 'Inactive'),
            self::STATUS_ACTIVE => Yii::t('cms/post', 'Active'),
        ];
    }
}