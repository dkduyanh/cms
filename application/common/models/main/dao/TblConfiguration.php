<?php

namespace common\models\main\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "{{%tbl_configuration}}".
 *
 * @property string $code
 * @property string $value
 */
class TblConfiguration extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%configuration}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('configuration', 'Code'),
            'value' => Yii::t('configuration', 'Value'),
        ];
    }
}
