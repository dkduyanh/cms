<?php

namespace common\models\cms\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "{{%tbl_cms_comments}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $title
 * @property string $body
 * @property string $created_date
 * @property integer $creator_id
 * @property string $creator_name
 * @property string $creator_email
 * @property string $creator_ip
 * @property string $last_modified_date
 * @property integer $last_modifier_id
 * @property integer $like_count
 * @property integer $dislike_count
 * @property integer $parent_id
 * @property integer $status
 */
class TblCmsComments extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id', 'creator_id', 'last_modifier_id', 'like_count', 'dislike_count', 'parent_id', 'status'], 'integer'],
            [['body'], 'string'],
            [['created_date', 'last_modified_date'], 'safe'],
            [['title'], 'string', 'max' => 512],
            [['creator_name'], 'string', 'max' => 256],
            [['creator_email'], 'string', 'max' => 255],
            [['creator_ip'], 'string', 'max' => 39],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms/comment', 'ID'),
            'post_id' => Yii::t('cms/comment', 'Post ID'),
            'title' => Yii::t('cms/comment', 'Title'),
            'body' => Yii::t('cms/comment', 'Body'),
            'created_date' => Yii::t('cms/comment', 'Created Date'),
            'creator_id' => Yii::t('cms/comment', 'Creator ID'),
            'creator_name' => Yii::t('cms/comment', 'Creator Name'),
            'creator_email' => Yii::t('cms/comment', 'Creator Email'),
            'creator_ip' => Yii::t('cms/comment', 'Creator Ip'),
            'last_modified_date' => Yii::t('cms/comment', 'Last Modified Date'),
            'last_modifier_id' => Yii::t('cms/comment', 'Last Modifier ID'),
            'like_count' => Yii::t('cms/comment', 'Like Count'),
            'dislike_count' => Yii::t('cms/comment', 'Dislike Count'),
            'parent_id' => Yii::t('cms/comment', 'Parent ID'),
            'status' => Yii::t('cms/comment', 'Status'),
        ];
    }
}
