<?php

namespace backend\models;

use common\library\Utils;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\main\SystemLog;
use yii\db\Expression;

/**
 * SystemLogSearch represents the model behind the search form of `backend\models\main\SystemLog`.
 */
class SystemLogSearch extends SystemLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'level'], 'integer'],
            [['env', 'category', 'message', 'extras'], 'safe'],
            [['created'], 'validateDateTime'],
        ];
    }

    public function validateDateTime($attribute, $params, $validator)
    {
        if(!Utils::isValidDateFormat($this->$attribute, 'd/m/Y')){
            $this->addError($attribute, 'Invalid format');
        }
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
        $query = SystemLog::find();

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
            'level' => $this->level,
            //'created' => $this->created,
        ]);

        //filter by created time
        if(!empty($this->created)){
            $createdFrom = Utils::formatDate($this->created, 'd/m/Y', 'Y-m-d 00:00:00');
            $createdUntil = Utils::formatDate($this->created, 'd/m/Y', 'Y-m-d 23:59:59');
            $query->andFilterWhere(['BETWEEN', 'created', new Expression("UNIX_TIMESTAMP('{$createdFrom}')"), new Expression("UNIX_TIMESTAMP('{$createdUntil}')")]);
            //;
        }


        $query->andFilterWhere(['like', 'env', $this->env])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'message', $this->message])
            ;

        return $dataProvider;
    }
}
