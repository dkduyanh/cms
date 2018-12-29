<?php

namespace backend\models\cms;


class Field extends \common\models\cms\Field
{
    const   DATATYPE_NUMBER = 'number',
	        DATATYPE_STRING = 'string',
	        DATATYPE_ARRAY = 'array',
	        DATATYPE_JSON = 'json';

	const   INPUT_TEXT = 'text',
            INPUT_PASSWORD = 'password',
            INPUT_RADIO = 'radio',
            INPUT_SELECT = 'select',
            INPUT_CHECKBOX = 'checkbox',
            INPUT_TEXTAREA = 'textarea',
            INPUT_FILE = 'file',
            INPUT_HIDDEN = 'hidden',
            INPUT_EDITOR = 'editor';

    /**
     * Get list of pre-defined input types
     * @return string[]
     */
    public static function getInputTypes()
    {
        return array(
            self::INPUT_TEXT => 'Text',
            self::INPUT_PASSWORD => 'Password',
            self::INPUT_RADIO => 'Radio',
            self::INPUT_SELECT => 'Dropdown',
            self::INPUT_CHECKBOX => 'Checkbox',
            self::INPUT_TEXTAREA => 'Text-area',
            self::INPUT_EDITOR => 'Editor',
            self::INPUT_FILE => 'File',
            self::INPUT_HIDDEN => 'Hidden'
        );
    }

    /**
     * Get list of pre-defined data types
     * @return string[]
     */
    public static function getDataTypes()
    {
        return [
            'text' => 'Text',
            'number' => 'Number'
        ];
    }

    /**
     * List all fields
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function listAll()
    {
        return self::find()->all();
    }
}