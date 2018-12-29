<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\main\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'birthplace', 'creator_id', 'last_modifier_id', 'verified', 'status'], 'integer'],
            [['code', 'username', 'email', 'phone', 'password', 'firstname', 'lastname', 'fullname', 'displayname', 'birthdate', 'image', 'title', 'about_me', 'description', 'created_date', 'last_modified_date', 'last_password_changed_date', 'last_login_date', 'last_access_date', 'last_verified_date', 'timezone', 'language', 'settings'], 'safe'],
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
        $query = User::find()->with('roles');

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
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'birthplace' => $this->birthplace,
            'creator_id' => $this->creator_id,
            'created_date' => $this->created_date,
            'last_modifier_id' => $this->last_modifier_id,
            'last_modified_date' => $this->last_modified_date,
            'last_password_changed_date' => $this->last_password_changed_date,
            'last_login_date' => $this->last_login_date,
            'last_access_date' => $this->last_access_date,
            'last_verified_date' => $this->last_verified_date,
            'verified' => $this->verified,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'displayname', $this->displayname])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'about_me', $this->about_me])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'settings', $this->settings]);

        return $dataProvider;
    }
}
