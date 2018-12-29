<?php

namespace common\models\main;

use common\library\Utils;
use common\models\ExtrasTrait;
use Yii;
use common\models\main\dao\TblMenuItems;

class MenuItem extends TblMenuItems
{
    use ExtrasTrait;

    const   STATUS_ACTIVE = 1,
            STATUS_INACTIVE = 0;

    const   TYPE_EMAIL = 'email',
	        TYPE_PHONE = 'tel',
	        TYPE_URL = 'url',
            TYPE_CUSTOM = 'custom';

    /**
     *
     */
    public function afterFind()
    {
        /*if(!empty($this->params) && !is_array($this->params)){
            $this->params = json_decode($this->params, true);
        } else {
            $this->params = [];
        }*/
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

    public function getLinkUrl()
    {
    	if($this->type == self::TYPE_EMAIL){
    		if(Utils::startsWith($this->link, 'mailto:')){

		    }
		    return 'mailto:'.$this->link;
	    }
	    else if($this->type == self::TYPE_PHONE){
		    if(Utils::startsWith($this->link, 'tel:')){

		    }
		    return 'tel:'.$this->link;
	    }
	    else if($this->type == self::TYPE_URL){
    		return $this->link;
	    }

	    return $this->link;
	    //else if($this->type == self::TYPE_CUSTOM){
			//return array_merge([$this->route], parse_url($this->params));
	    //}
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->encodeExtraData();
        return parent::beforeSave($insert);
    }

    /**
     * Get menu info
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * Get parent item info
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
    	return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }
    
    /**
     * Get children info
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
    	return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }
    
    /**
     * Check if this item has children
     * @return boolean
     */
    public function hasChildren()
    {
    	return (bool) count($this->children);
    }

    /**
     * Check if this item has a parent
     * @return bool
     */
    public function hasParent()
    {
    	return empty($this->parent_id);
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
     * Get image url
     * @return mixed
     */
    public function getImageUrl()
    {
        if($this->image){
            return Url::to(['@web/'.$this->image]);
        }
        return;
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