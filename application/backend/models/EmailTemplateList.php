<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\main\EmailTemplate;

/**
 * EmailTemplateList represents the model behind the search form about `common\models\main\EmailTemplate`.
 */
class EmailTemplateList extends EmailTemplate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'last_modifier_id', 'allow_delete'], 'integer'],
            [['code', 'name', 'description', 'subject', 'body', 'sender_email', 'sender_name', 'created_date', 'last_modified_date'], 'safe'],
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
        $query = EmailTemplate::find();

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
            'created_date' => $this->created_date,
            'creator_id' => $this->creator_id,
            'last_modified_date' => $this->last_modified_date,
            'last_modifier_id' => $this->last_modifier_id,
            'allow_delete' => $this->allow_delete,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'sender_email', $this->sender_email])
            ->andFilterWhere(['like', 'sender_name', $this->sender_name]);

        return $dataProvider;
    }
}
