<?php

namespace backend\models;


use backend\models\cms\Category;

class CategoryForm extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'unique'],
            [['id', 'position', 'is_sticky', 'parent_id', 'status'], 'integer'],
            [['code', 'name', 'description', 'image', 'image_alt'], 'string'],
            [['position'], 'default', 'value' => 500],
            [['extras'], 'safe']
        ];
    }

    public function afterFind()
    {
        if($this->extras)
        {
            $this->extras = json_decode($this->extras, true);
        }
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if($this->extras)
        {
            $this->extras = json_encode($this->extras);
        }
        return parent::beforeSave($insert);
    }
}