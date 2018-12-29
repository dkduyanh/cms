<?php

namespace backend\models\cms;

class Type extends \common\models\cms\Type
{

    /**
     * @return array
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
     * List all types
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function listAll(array $params = array())
    {
        $query = self::find();
        if(!empty($params)){
        	$query->where($params);
        }
        return $query->all();
    }

    /**
     * Update field of type. Create field if not exists.
     * @param $fieldId
     * @param null $defaultValue
     * @param int $position
     */
    public function updateField($fieldId, $defaultValue = null, $multiple = 0, $position = 0)
    {
        $field = Field::findOne($fieldId);
        if($field === null)
        {
            return false;
        }
        $this->unlink('fields', $field, true);
        return $this->link('fields', $field, [
            'default_value' => $defaultValue,
            'multiple' => $multiple,
            'position' => $position
        ]);
    }
}