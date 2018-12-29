<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\Media;

/**
 * MediaList represents the model behind the search form about `common\models\cms\Media`.
 */
class MediaList extends Media
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'creator_id', 'last_modifier_id', 'is_visible', 'is_locked', 'position'], 'integer'],
            [['name', 'content_path', 'content', 'extension', 'mime', 'hash', 'metadata', 'created_date', 'last_modified_date'], 'safe'],
            [['size'], 'number'],
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
        $query = Media::find();

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
            'parent_id' => $this->parent_id,
            'size' => $this->size,
            'creator_id' => $this->creator_id,
            'created_date' => $this->created_date,
            'last_modifier_id' => $this->last_modifier_id,
            'last_modified_date' => $this->last_modified_date,
            'is_visible' => $this->is_visible,
            'is_locked' => $this->is_locked,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content_path', $this->content_path])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'extension', $this->extension])
            ->andFilterWhere(['like', 'mime', $this->mime])
            ->andFilterWhere(['like', 'hash', $this->hash])
            ->andFilterWhere(['like', 'metadata', $this->metadata]);

        return $dataProvider;
    }
}
