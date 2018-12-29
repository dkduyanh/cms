<?php

namespace common\models\main\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "tbl_roles".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $created_date
 * @property string $last_modified_date
 * @property integer $is_admin
 * @property integer $is_default
 */
class TblRoles extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['created_date', 'last_modified_date'], 'safe'],
            [['is_admin', 'is_default'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 1024],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'created_date' => Yii::t('app', 'Created Date'),
            'last_modified_date' => Yii::t('app', 'Last Modified Date'),
            'is_admin' => Yii::t('app', 'Is Admin'),
            'is_default' => Yii::t('app', 'Is Default'),
        ];
    }
}
