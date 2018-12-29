<?php

namespace backend\models;

use backend\models\main\Menu;

class MenuForm extends Menu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 1024],
            [['code'], 'unique'],

            [['htmlClass', 'htmlStyle'], 'string'],
            [['show_items', 'show_selected_items', 'show_selected_parents'], 'boolean'],
        ];
    }
}