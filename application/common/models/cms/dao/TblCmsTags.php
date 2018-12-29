<?php

namespace common\models\cms\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "{{%tbl_cms_tags}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $weight
 */
class TblCmsTags extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['weight'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms/tag', 'ID'),
            'name' => Yii::t('cms/tag', 'Name'),
            'weight' => Yii::t('cms/tag', 'Weight'),
        ];
    }
}
