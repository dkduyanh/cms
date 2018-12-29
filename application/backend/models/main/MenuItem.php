<?php

namespace backend\models\main;


class MenuItem extends \common\models\main\MenuItem
{
    public static function listTypes(){
        return [
            'Link' => [
                'url' => 'URL',
                'email' => 'Email',
                'alias' => 'Alias',
            ],
            'CMS' => [
                'cms/post' => 'Single Post',
                'cms/category' => 'List of posts in a category',
            ],
            'Custom' => [
                'custom' => 'Other'
            ],
        ];
    }
}