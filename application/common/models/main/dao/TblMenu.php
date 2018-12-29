<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $extras
 */
class TblMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'code' => Yii::t('menu', 'Code'),
            'name' => Yii::t('menu', 'Name'),
            'description' => Yii::t('menu', 'Description'),
            'show_items' => Yii::t('menu', 'Show Items'),
            'show_selected_items' => Yii::t('menu', 'Show Selected Items'),
            'show_selected_parents' => Yii::t('menu', 'Show Selected Parents'),
            'status' => Yii::t('menu', 'Status'),
            'extras' => Yii::t('menu', 'Extras'),
        ];
    }
}
