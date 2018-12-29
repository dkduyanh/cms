<?php

namespace common\models\cms\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "{{%tbl_cms_posts}}".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $code
 * @property string $title
 * @property string $intro
 * @property string $body
 * @property string $filtered_body
 * @property string $image
 * @property string $image_alt
 * @property string $created_date
 * @property integer $creator_id
 * @property string $last_modified_date
 * @property integer $last_modifier_id
 * @property string $published_date
 * @property string $expiry_date
 * @property string $average_rating
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $dislike_count
 * @property integer $comment_count
 * @property integer $allow_comment
 * @property integer $allow_search
 * @property integer $privacy
 * @property integer $is_sticky
 * @property integer $parent_id
 * @property integer $position
 * @property integer $status
 * @property string $extras
 */
class TblCmsPosts extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id', 'creator_id', 'last_modifier_id', 'view_count', 'like_count', 'dislike_count', 'comment_count', 'allow_comment', 'allow_search', 'privacy', 'is_sticky', 'parent_id', 'position', 'status'], 'integer'],
            [['intro', 'body', 'filtered_body', 'extras'], 'string'],
            [['created_date', 'last_modified_date', 'published_date', 'expiry_date'], 'safe'],
            [['average_rating'], 'number'],
            [['code'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 1024],
            [['image', 'image_alt'], 'string', 'max' => 256],
            [['code'], 'unique'],
        ];
    }
}
