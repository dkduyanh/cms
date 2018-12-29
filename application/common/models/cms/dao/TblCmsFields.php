<?php

namespace common\models\cms\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "{{%tbl_cms_fields}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $input_type
 * @property string $data_type
 * @property string is_required,
 * @property string default_value,
 * @property string $hint
 * @property string $group
 * @property integer $position
 * @property string $settings
 */
class TblCmsFields extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_fields}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms/field', 'ID'),
            'code' => Yii::t('cms/field', 'Code'),
            'name' => Yii::t('cms/field', 'Name'),
            'description' => Yii::t('cms/field', 'Description'),
	        'input_type' => Yii::t('cms/field', 'Input Type'),
	        'data_type' => Yii::t('cms/field', 'Data Type'),
	        'is_required' => Yii::t('cms/field', 'Required'),
	        'default_value' => Yii::t('cms/field', 'Default Value'),
	        'hint' => Yii::t('cms/field', 'Hint'),
            'group' => Yii::t('cms/field', 'Group'),
            'position' => Yii::t('cms/field', 'Position'),
            'settings' => Yii::t('cms/field', 'Settings'),
        ];
    }
}
