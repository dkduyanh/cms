<?php

namespace backend\models;

use backend\models\main\MenuItem;

class MenuItemForm extends MenuItem
{
	public $type = null;

    public function rules()
    {
        return [
            [['menu_id'], 'required'],
            [['menu_id', 'position', 'parent_id', 'status'], 'integer'],
            [['name', 'link', 'route', 'image', /*'image_alt'*/], 'string', 'max' => 255],
            [['description', 'params'], 'string', 'max' => 1024],
            [['type'], 'string', 'max' => 50],
            [['target'], 'string', 'max' => 10],
            [['route', 'language'], 'string'],

            [['position'], 'default', 'value' => 500],
            //[['htmlStyle', 'htmlClass'], 'string']
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }
}