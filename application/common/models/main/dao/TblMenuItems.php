<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $image_alt
 * @property string $type
 * @property string $link
 * @property string $route
 * @property string $params
 * @property string $target
 * @property integer $position
 * @property integer $parent_id
 * @property integer $status
 * @property string $extras
 */
class TblMenuItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'menu_id' => Yii::t('menu', 'Menu ID'),
            'name' => Yii::t('menu', 'Name'),
            'description' => Yii::t('menu', 'Description'),
        	'image' => Yii::t('menu', 'Image'),
        	'image_alt' => Yii::t('menu', 'Image Alt'),
        	'type' => Yii::t('menu', 'Type'),
            'link' => Yii::t('menu', 'Link'),
        	'route' => Yii::t('menu', 'Route'),
        	'params' => Yii::t('menu', 'Params'),
            'target' => Yii::t('menu', 'Target'),
            'position' => Yii::t('menu', 'Position'),
            'parent_id' => Yii::t('menu', 'Parent ID'),
            'status' => Yii::t('menu', 'Status'),
            'language' => Yii::t('menu', 'Language'),
        ];
    }
}
