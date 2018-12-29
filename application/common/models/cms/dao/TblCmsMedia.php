<?php

namespace common\models\cms\dao;

use common\models\Dao;
use Yii;

/**
 * This is the model class for table "tbl_cms_media".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $content_path
 * @property resource $content
 * @property double $size
 * @property string $extension
 * @property string $mime
 * @property string $hash
 * @property string $metadata
 * @property integer $creator_id
 * @property string $created_date
 * @property integer $last_modifier_id
 * @property string $last_modified_date
 * @property integer $is_visible
 * @property integer $is_locked
 * @property string $position
 */
class TblCmsMedia extends Dao
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'creator_id', 'last_modifier_id', 'is_visible', 'is_locked', 'position'], 'integer'],
            [['name', 'is_visible', 'is_locked'], 'required'],
            [['content', 'metadata'], 'string'],
            [['size'], 'number'],
            [['created_date', 'last_modified_date'], 'safe'],
            [['name', 'content_path', 'mime'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 10],
            [['hash'], 'string', 'max' => 128],
            [['parent_id', 'name'], 'unique', 'targetAttribute' => ['parent_id', 'name'], 'message' => 'The combination of Parent ID and Name has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms/media', 'ID'),
            'parent_id' => Yii::t('cms/media', 'Parent ID'),
            'name' => Yii::t('cms/media', 'Name'),
            'content_path' => Yii::t('cms/media', 'Content Path'),
            'content' => Yii::t('cms/media', 'Content'),
            'size' => Yii::t('cms/media', 'Size'),
            'extension' => Yii::t('cms/media', 'Extension'),
            'mime' => Yii::t('cms/media', 'Mime'),
            'hash' => Yii::t('cms/media', 'Hash'),
            'metadata' => Yii::t('cms/media', 'Metadata'),
            'creator_id' => Yii::t('cms/media', 'Creator ID'),
            'created_date' => Yii::t('cms/media', 'Created Date'),
            'last_modifier_id' => Yii::t('cms/media', 'Last Modifier ID'),
            'last_modified_date' => Yii::t('cms/media', 'Last Modified Date'),
            'is_visible' => Yii::t('cms/media', 'Is Visible'),
            'is_locked' => Yii::t('cms/media', 'Is Locked'),
            'position' => Yii::t('cms/media', 'Position'),
        ];
    }
}
