<?php

namespace backend\models\main;


use yii\helpers\ArrayHelper;

class Menu extends \common\models\main\Menu
{
    public function listItemsDropdown()
    {
        $query = $this->getItems()->orderBy('position ASC');
        $query->andWhere(['not in', 'id', $this->id]);
        return ArrayHelper::map($query->all(), 'id', 'name');
    }
}