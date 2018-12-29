<?php

namespace backend\models;

use backend\models\cms\Field;
use backend\models\cms\Post;
use common\models\cms\PostField;
use common\models\CmsConfiguration;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PostForm extends Model
{
    public $_template;

    protected $_post;
    protected $_tags;
    protected $_categories;
    protected $_fields;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['tags', 'string'],
			['categories', 'safe'],
			['Post', 'safe'],
			['PostFields', 'safe'],
		];
	}

	/**
	 * Returns the form name
	 * @return string
	 */
	public function formName() {
		return '';
	}

	public function setPost($post){
		if($post instanceof \common\models\cms\Post){
			$this->_post = $post;
		} else if($this->_post instanceof \common\models\cms\Post && is_array($post)){
			$this->_post->setAttributes($post);
		}
	}

	public function getPost()
	{
		return $this->_post;
	}

	public function setCategories($categories)
	{
		$this->_categories = $categories;
	}

	public function getCategories()
	{
		//TODO :: CHECK POST IS NOT NULL
		if($this->_categories === null){
			if($this->post->isNewRecord){
				$this->_categories = [];
			} else {
				$this->_categories = ArrayHelper::getColumn($this->post->categories, 'id');
			}
		}
		return $this->_categories;
	}

	public function setTags($tags)
	{
		$this->_tags = $tags;
	}

	public function getTags()
	{
		if($this->_tags === null){
			if($this->post->isNewRecord){
				$this->_tags = '';
			} else {
				$string = [];
				foreach($this->post->tags as $tag)
				{
					$string[] = $tag->name;
				}
				$this->_tags = implode(', ', $string);
			}
		}
		return $this->_tags;
	}

	protected function getPostField($id = null){
		$field = null;
		if(!empty($id) && strpos($id, 'new') === false){
				$field = PostField::find()->where(['id' => $id])->one();
		}
		if($field === null){
			$field = new PostField();
			$field->post_id = $this->post->id;
		}
		return $field;
	}

	public function setPostFields($fields)
	{
		foreach($fields as $id => $postField){
			if(is_array($postField)){
				$this->_fields[$id] = $this->getPostField($id);
				if($this->_fields[$id] instanceof PostField){
					$this->_fields[$id]->setAttributes($postField);
				}
			} elseif($postField instanceof PostField){
				$this->_fields[$postField->id] = $postField;
			}
		}
	}

	public function getPostFields()
	{
		if($this->_fields === null){
			//load fields
			if($this->_post->isNewRecord)
			{
				$this->_fields = [];
			} else {
				$this->_fields = ArrayHelper::index($this->post->postFields, 'id');
			}

			//create empty field
			if(!empty($this->post->type->fields) && is_array($this->post->type->fields)){
				$fields = ArrayHelper::getColumn($this->_fields, 'field_id');
				$i = 0;
				foreach($this->post->type->fields as $field){
					if(!in_array($field->id, $fields)){
						$newPostField = $this->getPostField();
						$newPostField->field_id = $field->id;
						$this->_fields['new'.$i] = $newPostField;
						$i++;
					}
				}
			}
		}
		return  $this->_fields;
	}

	public function save()
	{
		if(!$this->validate()){
			die('k');
			return false;
		}

		//save post info
		if($this->post->extras)
		{
			$this->post->extras = json_encode($this->post->extras);
		}
		$this->post->code = null;
		if(!$this->post->save()){
			return false;
		}

		//update tags
		if(!$this->saveTags())
		{
			die('faied tag'.$this->tags);
			return false;
		}

		//update category
		if(!$this->saveCategories()){
			die('fail cate');
			return false;
		}

		//update fields
		if(!$this->savePostFields()){
			die('failed update fields');
	}
		return true;
	}

	protected function saveTags()
	{
		return $this->post->updateTags($this->tags);
	}

	protected function saveCategories()
	{
		return $this->post->updateCategories($this->_categories);
	}

	protected function savePostFields()
	{
		if(empty($this->post)) throw new \Exception('Create post first!');
		foreach($this->postFields as $postField)
		{
			$postField->post_id = $this->post->id;
			if(!$postField->save()){
				//TODO :: ROLL BACK
				return false;
			}
		}
		return true;
	}

	public function errorSummary($form)
	{
		$errorLists = [];
		foreach ($this->getAllModels() as $id => $model) {
			$errorList = $form->errorSummary($model, [
				'header' => '<p>Please fix the following errors for <b>' . $id . '</b></p>',
			]);
			$errorList = str_replace('<li></li>', '', $errorList); // remove the empty error
			$errorLists[] = $errorList;
		}
		return implode('', $errorLists);
	}

	private function getAllModels()
	{
		return [
			'Post' => $this->post,
		];
	}

    public function duplicate()
    {
        $clone = new self();

        //clone post
        $clone->post = new Post();
        $clone->post->attributes = $this->post->attributes; //$clone->post->setAttributes($this->post->attributes, false);

	    //touch post (don't clone the created and last modified date)
	    $clone->post->created_date = gmdate('Y-m-d H:i:s');
	    $clone->post->creator_id =  null;
	    $clone->post->last_modified_date = null;
	    $clone->post->last_modifier_id =  null;

	    //modified title, code, status
        $conf = new CmsConfiguration();
        $clone->post->title = $conf->postDuplicateTitlePrefix.$clone->post->title.$conf->postDuplicateTitleSuffix;
	    $clone->post->code = null;
        if($conf->postDuplicateStatus != ''){
	        $clone->post->status = $conf->postDuplicateStatus;
        }

        //clone attributes
	    $clone->setTags($this->getTags());
        $clone->setCategories($this->getCategories());
        $clone->setPostFields($this->getPostFields());

        return $clone;

        /**/
    }
}