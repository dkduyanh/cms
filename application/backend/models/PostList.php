<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\cms\Post;

/**
 * PostList represents the model behind the search form about `common\models\cms\Post`.
 */
class PostList extends Post
{
    public $categories;

    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'creator_id', 'last_modifier_id', 'view_count', 'like_count', 'dislike_count', 'comment_count', 'allow_comment', 'allow_search', 'privacy', 'is_sticky', 'parent_id', 'position', 'status'], 'integer'],
            [['code', 'title', 'intro'], 'string'],
            [['body', 'filtered_body', 'created_date', 'last_modified_date', 'published_date', 'expiry_date', 'extras'], 'safe'],
            [['average_rating'], 'number'],
            [['categories'], 'integer'],
            [['language'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($typeId, $params)
    {
        $query = Post::find()->with('categories')->where(['type_id' => $typeId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //Filtering by categories
        if($this->categories)
        {
            $query->innerJoinWith('categories c')->where(['c.id' => $this->categories]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            self::tableName().'.created_date' => $this->created_date,
            self::tableName().'.creator_id' => $this->creator_id,
            self::tableName().'.last_modified_date' => $this->last_modified_date,
            self::tableName().'.last_modifier_id' => $this->last_modifier_id,
            'published_date' => $this->published_date,
            'expiry_date' => $this->expiry_date,
            'average_rating' => $this->average_rating,
            'view_count' => $this->view_count,
            'like_count' => $this->like_count,
            'dislike_count' => $this->dislike_count,
            'comment_count' => $this->comment_count,
            'allow_comment' => $this->allow_comment,
            'allow_search' => $this->allow_search,
            'privacy' => $this->privacy,
            self::tableName().'.is_sticky' => $this->is_sticky,
            'parent_id' => $this->parent_id,
            'position' => $this->position,
            'language' => $this->language,
            self::tableName().'.status' => $this->status,
        ]);

        //search like
        $query->andFilterWhere(['OR',
            ['like', self::tableName().'.code', $this->code],
            ['like', 'title', $this->title],
            ['like', 'intro', $this->intro]
        ]);

        return $dataProvider;
    }
}
