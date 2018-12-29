<?php

namespace common\models\main;

use common\models\ExtrasTrait;
use Yii;
use common\models\main\dao\TblMenu;

class Menu extends TblMenu
{
    use ExtrasTrait;

    const   STATUS_ACTIVE = 1,
            STATUS_INACTIVE = 0;

    /**
     *
     */
    public function afterFind()
    {
        $this->loadExtraData();
        parent::afterFind();
    }

    public function getHtmlStyle()
    {
        return $this->getExtraData('html.style');
    }

    public function setHtmlStyle($value)
    {
        $this->setExtraData('html.style', $value);
    }

    public function getHtmlClass()
    {
        return $this->getExtraData('html.class');
    }

    public function setHtmlClass($value)
    {
        $this->setExtraData('html.class', $value);
    }

    /**
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->encodeExtraData();
        return parent::beforeSave($insert);
    }

    /**
     * Get menu items
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id']);
    }

    /**
     * Check if status is active
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
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
     * get list of status labels
     * @return array
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('menu', 'ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('menu', 'INACTIVE')
        ];
    }
}