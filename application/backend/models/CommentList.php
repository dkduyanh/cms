<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\Comment;

/**
 * CommentList represents the model behind the search form about `common\models\cms\Comment`.
 */
class CommentList extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_id', 'creator_id', 'last_modifier_id', 'like_count', 'dislike_count', 'parent_id', 'status'], 'integer'],
            [['title', 'body', 'created_date', 'creator_name', 'creator_email', 'creator_ip', 'last_modified_date'], 'safe'],
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
    public function search($params)
    {
        $query = Comment::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'post_id' => $this->post_id,
            'created_date' => $this->created_date,
            'creator_id' => $this->creator_id,
            'last_modified_date' => $this->last_modified_date,
            'last_modifier_id' => $this->last_modifier_id,
            'like_count' => $this->like_count,
            'dislike_count' => $this->dislike_count,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'creator_name', $this->creator_name])
            ->andFilterWhere(['like', 'creator_email', $this->creator_email])
            ->andFilterWhere(['like', 'creator_ip', $this->creator_ip]);

        return $dataProvider;
    }
}
