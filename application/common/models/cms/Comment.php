<?php

namespace common\models\cms;

use common\models\cms\dao\TblCmsComments;
use common\models\main\User;

class Comment extends TblCmsComments
{
    const STATUS_ACTIVE = 1,
          STATUS_INACTIVE = 0;

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
        return $this->hasOne(User::className(), ['id' => 'last_modified_id']);
    }

    /**
     * Checks if status is active
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}