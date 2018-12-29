<?php

namespace common\models\cms;

use common\models\CmsConfiguration;
use common\models\main\Configuration;
use Yii;
use common\models\cms\dao\TblCmsPosts;
use common\models\main\User;
use yii\behaviors\SluggableBehavior;
use yii\helpers\StringHelper;

class Post extends TblCmsPosts
{
    const   STATUS_ACTIVE = 1,
            STATUS_INACTIVE = 0,
            STATUS_PENDING = -1;

    const   STICKY_YES = 1,
            STICKY_NO = 0;

    /* public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'code'
            ],
        ];
    } */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms/post', 'ID'),
            'type_id' => Yii::t('cms/post', 'Type ID'),
            'code' => Yii::t('cms/post', 'Code'),
            'title' => Yii::t('cms/post', 'Title'),
            'intro' => Yii::t('cms/post', 'Intro'),
            'body' => Yii::t('cms/post', 'Body'),
            'filtered_body' => Yii::t('cms/post', 'Filtered Body'),
            'image' => Yii::t('cms/post', 'Image'),
            'image_alt' => Yii::t('cms/post', 'Image Alt'),
            'created_date' => Yii::t('cms/post', 'Created Date'),
            'creator_id' => Yii::t('cms/post', 'Creator ID'),
            'last_modified_date' => Yii::t('cms/post', 'Last Modified Date'),
            'last_modifier_id' => Yii::t('cms/post', 'Last Modifier ID'),
            'published_date' => Yii::t('cms/post', 'Published Date'),
            'expiry_date' => Yii::t('cms/post', 'Expiry Date'),
            'average_rating' => Yii::t('cms/post', 'Average Rating'),
            'view_count' => Yii::t('cms/post', 'View Count'),
            'like_count' => Yii::t('cms/post', 'Like Count'),
            'dislike_count' => Yii::t('cms/post', 'Dislike Count'),
            'comment_count' => Yii::t('cms/post', 'Comment Count'),
            'allow_comment' => Yii::t('cms/post', 'Allow Comment'),
            'allow_search' => Yii::t('cms/post', 'Allow Search'),
            'privacy' => Yii::t('cms/post', 'Privacy'),
            'is_sticky' => Yii::t('cms/post', 'Is Sticky'),
            'parent_id' => Yii::t('cms/post', 'Parent ID'),
            'position' => Yii::t('cms/post', 'Position'),
            'status' => Yii::t('cms/post', 'Status'),
            'extras' => Yii::t('cms/post', 'Extras'),
            'language' => Yii::t('cms/post', 'Language'),
        ];
    }

    /**
     * Get status label
     * @return string
     */
    public function getStatusLabel()
    {
        return @self::statusLabels()[$this->status];
    }

    /**
     * Check if this is stick post
     * @return bool
     */
    public function isSticky()
    {
        return $this->is_sticky == self::STICKY_YES;
    }

	/**
	 * Check if the post is active
	 * @return bool
	 */
    public function isActive()
    {
    	return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * Get sticky status label
     * @return string
     */
    public function getStickyLabel()
    {
        return @self::stickyLabels()[$this->is_sticky];
    }

    public function getAllowSearchLabel()
    {
        return $this->allow_search == '1' ? Yii::t('cms/post', 'YES') : Yii::t('cms/post', 'NO');
    }

    public function getAllowCommentLabel()
    {
        return $this->allow_comment == '1' ? Yii::t('cms/post', 'YES') : Yii::t('cms/post', 'NO');
    }

    /**
     * Get creator info
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * Get last modifier
     * @return \yii\db\ActiveQuery
     */
    public function getLastModifier()
    {
        return $this->hasOne(User::className(), ['id' => 'last_modifier_id']);
    }

    /**
     * Get post type info
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
     * Gets tags of this post
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable(self::tablePrefix().'cms_post_tag', ['post_id' => 'id']);
    }

    /**
     * Gets categories of this post
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable(self::tablePrefix().'cms_post_category', ['post_id' => 'id']);
    }

    /**
     * Get parent of this post
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

	/**
	 * Get field-value objects of this post
	 * @return \yii\db\ActiveQuery
	 */
    public function getPostFields()
    {
    	return $this->hasMany(PostField::className(), ['post_id' => 'id']);
    }

	/**
	 * List related fields of this post
	 * @return $this
	 */
    public function getFields()
    {
    	return $this->hasMany(Field::className(), ['id' => 'field_id'])->via('postFields');
    }

    /**
     * Get post image url
     * @return string|NULL
     */
    public function getImageUrl()
    {
    	if(isset($this->image) && trim($this->image) != ''){
    		if(StringHelper::startsWith($this->image, '//') || StringHelper::startsWith($this->image, 'http://') || StringHelper::startsWith($this->image, 'https://')){
    			return $this->image;
    		}
    		return UPLOADS_URL.'/'.$this->image;
    	} else {
    	    //try to load default image
    	    $defaultImage = Configuration::getValue('cms.post.default_image', null);
    	    if($defaultImage !== null){
                if(StringHelper::startsWith($this->image, '//') || StringHelper::startsWith($this->image, 'http://') || StringHelper::startsWith($this->image, 'https://')){
                    return $defaultImage;
                }
                return UPLOADS_URL.'/'.$defaultImage;
            }
        }
    	return null;
    }

    public function getImageAltUrl()
    {
        if(isset($this->image_alt) && trim($this->image_alt) != ''){
            if(StringHelper::startsWith($this->image_alt, '//') || StringHelper::startsWith($this->image_alt, 'http://') || StringHelper::startsWith($this->image_alt, 'https://')){
                return $this->image_alt;
            }
            return UPLOADS_URL.'/'.$this->image_alt;
        } else {
            //try to load default image
            $defaultImage = Configuration::getValue('cms.post.default_image', null);
            if($defaultImage !== null){
                if(StringHelper::startsWith($this->image_alt, '//') || StringHelper::startsWith($this->image_alt, 'http://') || StringHelper::startsWith($this->image_alt, 'https://')){
                    return $defaultImage;
                }
                return UPLOADS_URL.'/'.$defaultImage;
            }
        }
        return null;
    }

    /**
     * List all status labels
     * @return array
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_PENDING => Yii::t('cms/post', 'Pending'),
            self::STATUS_INACTIVE => Yii::t('cms/post', 'Inactive'),
            self::STATUS_ACTIVE => Yii::t('cms/post', 'Active'),
        ];
    }

    /**
     * List all sticky status labels
     * @return array
     */
    public static function stickyLabels()
    {
        return [
            self::STICKY_NO => Yii::t('cms/post', 'NO'),
            self::STICKY_YES => Yii::t('cms/post', 'YES'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($insert){
            if(empty($this->created_date)){
                $this->created_date = gmdate('Y-m-d H:i:s');
            }
        } else {
            if(empty($this->last_modified_date)){
                $this->last_modified_date = gmdate('Y-m-d H:i:s');
            }
        }

        return parent::beforeSave($insert);
    }

	/**
	 * @return bool
	 */
	public function beforeDelete() {
		//remove categories
		$this->unlinkAll('categories', true);
		//remove tags
		$this->unlinkAll('tags', true);
		//remove fields
		$this->unlinkAll('fields', true);

		return parent::beforeDelete();
	}


}