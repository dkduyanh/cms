<?php

namespace backend\models;

use backend\models\cms\Type;
use yii\base\InvalidParamException;
use yii\base\Model;

class FieldTypeForm extends Model
{
    private $_type;
    public $_fieldId, $_defaultValue, $_position, $_multiple;

    public function rules()
    {
        return [
        	[['_fieldId', '_position', '_multiple'], 'number'],
            [['_defaultValue'], 'safe'],
            ['_position', 'default', 'value' => 0],
            ['_defaultValue', 'default', 'value' => null],
        ];
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setType($type)
    {
        if($type instanceof Type)
        {
            $this->_type = $type;
        }
        else throw new InvalidParamException('Invalid data');
    }

    public function save()
    {
        if($this->validate() && $this->_type->updateField($this->_fieldId, $this->_defaultValue, $this->_multiple, $this->_position)){
            return true;
        }
        return false;
    }
}