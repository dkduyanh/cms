<?php

namespace common\models\cms\dao;

use Yii;

/**
 * This is the model class for table "{{%cms_types}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $plural_name
 * @property string $description
 * @property integer $is_visible
 * @property integer $show_title
 * @property integer $show_intro
 * @property integer $show_image
 * @property integer $show_image_alt
 * @property integer $show_body
 * @property integer $show_categories
 * @property integer $show_tags
 *
 * @property CmsPosts[] $cmsPosts
 * @property CmsTypeField[] $cmsTypeFields
 * @property CmsFields[] $fields
 */
class TblCmsTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['show_title', 'show_intro', 'show_image', 'show_image_alt', 'show_body', 'show_categories', 'show_tags'], 'integer'],
            [['code', 'name', 'plural_name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['code'], 'unique'],
	        [['is_visible'], 'boolean'],
	        [['is_visible'], 'default', 'value' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'plural_name' => Yii::t('app', 'Name (Plural)'),
            'description' => Yii::t('app', 'Description'),
            'is_visible' => Yii::t('app', 'Visible'),
            'show_title' => Yii::t('app', 'Show Title'),
            'show_intro' => Yii::t('app', 'Show Intro'),
            'show_image' => Yii::t('app', 'Show Image'),
            'show_image_alt' => Yii::t('app', 'Show Image Alt'),
            'show_body' => Yii::t('app', 'Show Body'),
            'show_categories' => Yii::t('app', 'Show Categories'),
            'show_tags' => Yii::t('app', 'Show Tags'),
        ];
    }

    public function attributeHints() {
	    return [
		    'plural_name' => '(optional) A plural descriptive name for the post type marked for translation.',
		    'description' => '(optional) A short descriptive summary of what the post type is.',
		    'is_visible' => 'Controls if the type is visible to users',
	    ];

    }
}
