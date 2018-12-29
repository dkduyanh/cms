<?php

namespace common\models\cms\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "{{%tbl_cms_categories}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $created_date
 * @property integer $creator_id
 * @property string $last_modified_date
 * @property integer $last_modifier_id
 * @property string $image
 * @property string $image_alt
 * @property integer $position
 * @property integer $is_sticky
 * @property integer $parent_id
 * @property integer $status
 * @property string $settings
 */
class TblCmsCategories extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['created_date', 'last_modified_date'], 'safe'],
            [['creator_id', 'last_modifier_id', 'position', 'is_sticky', 'parent_id', 'status'], 'integer'],
            [['extras'], 'string'],
            [['code', 'name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['image', 'image_alt'], 'string', 'max' => 256],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms/category', 'ID'),
            'code' => Yii::t('cms/category', 'Code'),
            'name' => Yii::t('cms/category', 'Name'),
            'description' => Yii::t('cms/category', 'Description'),
            'created_date' => Yii::t('cms/category', 'Created Date'),
            'creator_id' => Yii::t('cms/category', 'Creator ID'),
            'last_modified_date' => Yii::t('cms/category', 'Last Modified Date'),
            'last_modifier_id' => Yii::t('cms/category', 'Last Modifier ID'),
            'image' => Yii::t('cms/category', 'Image'),
            'image_alt' => Yii::t('cms/category', 'Image Alt'),
            'position' => Yii::t('cms/category', 'Position'),
            'is_sticky' => Yii::t('cms/category', 'Is Sticky'),
            'parent_id' => Yii::t('cms/category', 'Parent ID'),
            'status' => Yii::t('cms/category', 'Status'),
            'extras' => Yii::t('cms/category', 'Extras'),
        ];
    }
}
