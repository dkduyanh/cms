<?php

namespace common\models\cms\dao;

use common\models\cms\Field;
use common\models\cms\Post;
use Yii;

/**
 * This is the model class for table "{{%cms_post_field}}".
 *
 * @property string $id
 * @property string $post_id
 * @property string $field_id
 * @property string $value
 *
 * @property CmsPosts $post
 * @property CmsFields $field
 */
class TblCmsPostField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_post_field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'field_id'], 'required'],
            [['post_id', 'field_id'], 'integer'],
            [['value'], 'string'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('postfield', 'ID'),
            'post_id' => Yii::t('postfield', 'Post ID'),
            'field_id' => Yii::t('postfield', 'Field ID'),
            'value' => Yii::t('postfield', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }
}
