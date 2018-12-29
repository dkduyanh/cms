<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\main\Cronjob;

/**
 * CronjobSearch represents the model behind the search form of `backend\models\main\Cronjob`.
 */
class CronjobSearch extends Cronjob
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'type', 'command', 'created_date', 'last_modified_date', 'start_date', 'end_date', 'interval', 'next_run_date', 'last_run_date', 'last_run_result'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Cronjob::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                    'id' => SORT_ASC
                ]
            ]
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
            'type' => $this->type,
            'created_date' => $this->created_date,
            'last_modified_date' => $this->last_modified_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'next_run_date' => $this->next_run_date,
            'last_run_date' => $this->last_run_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'interval', $this->interval]);

        return $dataProvider;
    }
}
