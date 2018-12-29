<?php

namespace backend\models\cms;

use Yii;
use yii\helpers\ArrayHelper;

class Post extends \common\models\cms\Post
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id', 'creator_id', 'last_modifier_id', 'view_count', 'like_count', 'dislike_count', 'comment_count', 'allow_comment', 'allow_search', 'privacy', 'is_sticky', 'parent_id', 'position', 'status'], 'integer'],
            [['intro', 'body', 'filtered_body'], 'string'],
            [['created_date', 'last_modified_date', 'published_date', 'expiry_date'], 'safe'],
            [['average_rating'], 'number'],
            [['code'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 1024],
            [['image', 'image_alt'], 'string', 'max' => 256],
            [['language'], 'string', 'max' => 5],
            [['code'], 'unique'],
	        [['extras'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'type.name' => Yii::t('cms/post', 'Type'),
            'creator.displayname' => Yii::t('cms/post', 'Creator'),
            'lastModifier.displayname' => Yii::t('cms/post', 'Last Modifier'),
            'statusLabel' => Yii::t('cms/post', 'Status'),
        ]);
    }

    /**
     * @return string
     */
    public function getStatusClass()
    {
        $class = [
            Post::STATUS_ACTIVE => 'label label-success',
            Post::STATUS_INACTIVE => 'label label-danger',
            Post::STATUS_PENDING => 'label label-warning',
        ];
        return @$class[$this->status];
    }

    /**
     * @return string
     */
    public function getStickyClass()
    {
        $class = [
            Post::STICKY_YES => 'label label-success',
            Post::STICKY_NO => 'label label-danger',
        ];
        return @$class[$this->is_sticky];
    }



    /**
     * Remove all tags
     * @return number of affected rows
     */
    public function removeAllTags()
    {
        if(empty($this->id)) return false;
        $cmd = self::getDb()->createCommand();
        $intResult = $cmd->delete('tbl_cms_post_tag', "post_id=:pid", array(
            ':pid'=>$this->id
        ))->execute();
        return $intResult;
    }

    /**
     * Adds tags to this post
     * @param string|array $tags
     * @return bool TRUE if tags are added successfully, FALSE otherwise
     */
    public function addTags($tags, $delimiter = ',')
    {
        //parse tags
        if(!is_array($tags)) {
            $tags = Tag::strToArray($tags, $delimiter);
        }

        //create un-available tags
        $availableTagObjs = Tag::find()->where(['name' => $tags])->all();
	    $availableTags = ArrayHelper::getColumn($availableTagObjs, 'name');
	    $unavailabelTags = array_diff($tags, $availableTags);
		foreach($unavailabelTags as $tag){
			$objTag = new Tag();
			$objTag->name = $tag;
			$objTag->save();

			$availableTagObjs[] = $objTag;
		}

		//unlink all old tags
	    //TODO :: instead of un-linking all old tags, just remove missing only
	    $this->unlinkAll('tags', true);

		//link new tags to post
		foreach ($availableTagObjs as $objTag){
			$this->link('tags', $objTag);
		}

		return true;
    }

    /**
     * Update new set of tags for this post
     * @param string|array $tags The list of tags of this post, empty value means remove all.
     * @return boolean TRUE if updated successfully, FALSE otherwise
     */
    public function updateTags($tags)
    {
        $this->removeAllTags();
        if($tags !== null && $tags != ''){
	        return $this->addTags($tags);
        }
        return true;
    }


    /**
     * Get categories of this post
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable(self::tablePrefix().'cms_post_category', ['post_id' => 'id']);
    }

    /**
     * Check if this post belongs to a category
     * @param int $catId
     * @throws \Exception
     * @return boolean
     */
    public function hasCategory($catId)
    {
        if(empty($catId)) throw new \Exception('Invalid category id');
        if(empty($this->id)) return false;

        $cmd = self::getDb()->createCommand("SELECT 1 FROM tbl_cms_post_category WHERE post_id = :pid AND category_id = :cid");
        $cmd->bindParam(":pid", $this->id, \PDO::PARAM_INT);
        $cmd->bindParam(":cid", $catId, \PDO::PARAM_INT);
        return (bool) $cmd->queryScalar();
    }

    /**
     * Add post into a category
     * @param int|array $catId
     * @throws \Exception
     * @return bool|int number of affected rows
     */
    public function addCategory($catId)
    {
        if(empty($catId)) return false;
        if(empty($this->id)) throw new \Exception('Empty post');

        $cmd = self::getDb()->createCommand();
        if(is_array($catId))
        {
            $rows = array();
            foreach($catId as $cid)
            {
                $rows[] = [$this->id, $cid];
            }
            $intResult = $cmd->batchInsert(self::tablePrefix().'cms_post_category', ['post_id', 'category_id'], $rows)->execute();
        }
        else {
            $intResult = $cmd->insert(self::tablePrefix().'cms_post_category', array(
                'post_id'=>$this->id,
                'category_id'=>$catId
            ))->execute();
        }
        return $intResult;
    }

    public function removeCategory($catId)
    {
        if(empty($catId)) throw new \Exception('Invalid category id');
        if(empty($this->id)) throw new \Exception('Empty post');

        $cmd = self::getDb()->createCommand();
        if(is_array($catId))
        {
            $cond = array();
            $condData = array([':pid' => $this->id]);
            foreach($catId as $i=>$cid)
            {
                $cond[] = "category_id = :cid{$i}";
                $condData[] = [":cid{$i}" => $cid];
            }
            $cond = implode(' OR ', $cond);

            $intResult = $cmd->delete(self::tablePrefix().'cms_post_category', "post_id=:pid AND ({$cond})", $condData)->execute();
        } else {
            $intResult = $cmd->delete(self::tablePrefix().'cms_post_category', 'post_id=:pid AND category_id=:cid', array(
                ':pid'=>$this->id,
                ':cid'=>$catId
            ))->execute();
        }
        return $intResult;
    }

    /**
     * Remove post from all categories
     * @return boolean
     */
    public function removeAllCategories()
    {
        return $this->unlinkAll('categories', true);
    }

    /**
     * Update new set of categories for this post
     * @param int|array $catIds
     * @return int number of affected rows
     */
    public function updateCategories($catIds) {
	    $this->removeAllCategories();
	    if ( ! empty( $catIds ) ) {
		    return $this->addCategory( $catIds );
	    }
	    return true;
    }


    /**
     * Check if this post has a field
     * @param str $fieldCode
     * @throws \Exception
     * @return boolean
     */
    public function hasField($fieldCode)
    {
        if($this->getFieldValue($fieldCode)){
        	return true;
        }
        return false;
    }

    /**
     * Get all custom values of the post
     * @return array
     * @example $fields = $post->getFieldValues(); var_dump($fields);
     *
     * Array[
     *      'my_field_1' => [
     *          '1' => 'Abc',
     *          '2' => 'Cde'
     *      ],
     *      'my_field_2' => [
     *          '9' => 'Happy',
     *      ],
     * ]
     */
    public function getFieldValues()
    {
        if($this->isNewRecord){
            return []; //TODO: LOAD DEFAULT FIELDS OF TYPE
        }

        //pull meta values from DB
        $table  = self::tablePrefix().'cms_post_field';
        $strSql = "SELECT id, field_id, value 
					FROM {$table}
					WHERE post_id = :pid
				  ";
        $cmd = self::getDb()->createCommand($strSql);
        $cmd->bindValue(":pid",$this->id,\PDO::PARAM_STR);
        $arrResults = $cmd->queryAll();

        return ArrayHelper::index($arrResults, 'id', 'field_id');
    }

	/**
	 * Gets value of field
	 * @param string $fieldCode
	 */
    public function getFieldValue($fieldCode)
    {
	    //TODO: UPDATE FIELD VALUE AFTER OBJECT SAVE FIELD
	    if(!isset($this->_fields[$fieldCode])){
		    $fields = $this->getFieldValues();
		    if(isset($fields[$fieldCode]))
			    $this->_fields[$fieldCode] = $fields[$fieldCode];
	    }
	    return $this->_fields[$fieldCode];
    }

	/**
	 * Add a field value to this post
	 * @param $fieldCode
	 * @param $value
	 *
	 * @return int|false The PostFieldID on success, false on failure.
	 * @throws \yii\db\Exception
	 *
	 * Usage: $post->addFieldValue('_myfield', 'abcd');
	 */
    public function addFieldValue($fieldCode, $value)
    {
    	//find field id from code
		$fieldId = Field::getIdByCode($fieldCode);

		//check if is valid field
	    $validFieldIds = ArrayHelper::getColumn($this->type->fields, 'id');
	    if(in_array($fieldId, $validFieldIds))
	    {
	    	//TODO :: CHECK IF THIS IS MULTIPLE VALUE FIELD OR NOT?
		    $table  = self::tablePrefix().'cms_post_field';
		    $strSql = "INSERT INTO {$table} (post_id, field_id, `value`) VALUES (:pid, :fid, :value); ";
		    $cmd = self::getDb()->createCommand($strSql);
		    $cmd->bindValue(":pid",$this->id,\PDO::PARAM_INT);
		    $cmd->bindValue(":fid",$fieldId,\PDO::PARAM_INT);
		    $cmd->bindValue(":value",$value,\PDO::PARAM_STR);
		    if($cmd->execute()){
		    	//TODO:: ADD TO CACHE
				return self::getDb()->getLastInsertID();
		    }
	    }
	    return false;
    }

	/**
	 * Update field value by id
	 * @param $postFieldId
	 * @param $value
	 *
	 * @return string
	 * @throws \yii\db\Exception
	 */
    public function updateFieldValue($postFieldId, $value)
    {
		if($this->getFieldValueById($postFieldId))
		{
			$table  = self::tablePrefix().'cms_post_field';
			$strSql = "UPDATE {$table} SET value = :value WHERE id = :pfid; ";
			$cmd = self::getDb()->createCommand($strSql);
			$cmd->bindValue(":pfid",$postFieldId,\PDO::PARAM_INT);
			$cmd->bindValue(":value",$value,\PDO::PARAM_STR);
			if($cmd->execute()){
				//TODO:: ADD TO CACHE
				return self::getDb()->getLastInsertID();
			}
		}
    }

	/**
	 * @param $postFieldId
	 *
	 * @return int
	 * @throws \yii\db\Exception
	 */
	public function deleteFieldValueById($postFieldId)
	{
		//pull meta values from DB
		$table  = self::tablePrefix().'cms_post_field';
		$strSql = "DELETE FROM {$table}
					WHERE id = :pfid
				  ";
		$cmd = self::getDb()->createCommand($strSql);
		$cmd->bindValue(":pfid",$postFieldId,\PDO::PARAM_STR);
		return $cmd->execute();
	}

    public function getFieldValueById($postFieldId)
    {
	    //pull meta values from DB
	    $table  = self::tablePrefix().'cms_post_field';
	    $strSql = "SELECT id, field_id, value 
					FROM {$table}
					WHERE id = :pfid
				  ";
	    $cmd = self::getDb()->createCommand($strSql);
	    $cmd->bindValue(":pfid",$postFieldId,\PDO::PARAM_STR);
	    return $cmd->queryOne();
    }



	/**
	 * Delete all fields of this post
	 * @return bool
	 * @throws \yii\db\Exception
	 */
	public function deleteAllFields()
	{
		//todo: delete từng field và remove trong cache
		$cmd = self::getDb()->createCommand("DELETE FROM tbl_cms_post_field WHERE post_id=:pid");
		$cmd->bindValue(":pid", $this->id);
		return (bool)$cmd->execute();
	}

    /**
     * Update field value
     * @param string $fieldCode
     * @param string $fieldValue
     * @return boolean
     */
    public function updateField($postFieldId, $value)
    {
    	/*$this->getFields();
        $fieldId = Field::getIdByCode($fieldCode);
        if($fieldId !== null){
            if($this->hasField($fieldId))
            {
                //update
                return (bool)self::getDb()->createCommand()->update(self::tablePrefix().'cms_post_field', ['value' => $fieldValue], 'post_id=:pid AND field_id=:fid', array(':pid'=>$this->id, ':fid'=>$fieldId))->execute();
            }
            else{
                //insert
                return (bool)self::getDb()->createCommand()->insert(self::tablePrefix().'cms_post_field', ['post_id' => $this->id, 'field_id' => $fieldId, 'value' => $fieldValue])->execute();
            }
        }
        return false;*/
    }
}