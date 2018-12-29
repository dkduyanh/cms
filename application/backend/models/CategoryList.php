<?php

namespace backend\models;

use common\library\utils\ArrayTreeBuilder;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\cms\Category;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * CategoryList represents the model behind the search form about `common\models\cms\Category`.
 */
class CategoryList extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id', 'creator_id', 'last_modifier_id', 'position', 'is_sticky', 'parent_id', 'status'], 'integer'],
            //[['code', 'name', 'description', 'created_date', 'last_modified_date', 'image', 'image_alt', 'extras'], 'safe'],
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
        $query = Category::find();

        // add conditions that should always apply here

        $dataProvider = new ArrayDataProvider([
            'allModels' => (new ArrayTreeBuilder(ArrayHelper::toArray($query->all())))->buildFlatTree(),
            'key' => 'id',
            'pagination' => false,
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
            'position' => $this->position,
            'is_sticky' => $this->is_sticky,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'image_alt', $this->image_alt]);

        return $dataProvider;
    }
}
