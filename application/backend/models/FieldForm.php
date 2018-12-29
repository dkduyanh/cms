<?php
/**
 * Created by PhpStorm.
 * User: DuyAnh
 * Date: 11/16/2017
 * Time: 4:55 PM
 */

namespace backend\models;


use backend\models\cms\Field;

class FieldForm extends Field
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'unique'],
            [['position'], 'integer'],
            [['settings'], 'validateSettings'],
            [['code', 'name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['group'], 'string', 'max' => 50],
            [['position'], 'default', 'value' => 500],
			['hint', 'string'],
	        ['is_required', 'boolean'],
	        [['input_type'], 'in', 'range' => array_keys(self::getInputTypes())],
	        ['data_type', 'in', 'range' => array_keys(self::getDataTypes())],
	        ['default_value', 'validateDefaultValue'],
        ];
    }

	function validateDefaultValue($attribute, $params, $validator)
	{
		if($this->data_type == self::DATATYPE_NUMBER && !is_numeric($this->$attribute)){
			$this->addError($attribute, 'Default value must be numeric');
		}
	}


    /**
     * Validate field settings
     * @param string $attribute
     * @param array $params
     * @return void
     */
    public function validateSettings($attribute, $params)
    {
        $attributeData = $this->$attribute;
        if(in_array($this->input_type, [self::INPUT_SELECT, self::INPUT_RADIO]) && (empty($attributeData['list']) || !is_array($attributeData['list'])))
        {
            $this->addError($attribute, 'Missing \'list\' attribute');
        }
    }

    public function afterFind()
    {
        if(is_string($this->settings))
        {
            $this->settings = json_decode($this->settings, true);
        }
    }

    public function beforeSave($insert)
    {
        if(is_array($this->settings))
        {
            $this->settings = json_encode($this->settings);
        }
        return parent::beforeSave($insert);
    }
}