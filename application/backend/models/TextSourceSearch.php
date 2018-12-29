<?php

namespace backend\models;

use backend\models\main\Language;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\main\TextSource;
use yii\helpers\ArrayHelper;

/**
 * TextSourceSearch represents the model behind the search form of `backend\models\main\TextSource`.
 */
class TextSourceSearch extends TextSource
{
    public $_translations;
    public $installedLanguages;

    /**
     * TextSourceSearch constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->installedLanguages = Language::listAll();
        parent::__construct($config);
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    function load($data, $formName = null)
    {
        if(isset($data['_translations']) && is_array($data['_translations'])){
            $installedLangs = ArrayHelper::getColumn($this->installedLanguages, 'code');
            foreach($data['_translations'] as $lang => $tran){
                if(!is_string($tran) || $tran == '' || !in_array($lang, $installedLangs)){
                    unset($data['_translations'][$lang]);
                }
            }
            $this->_translations = $data['_translations'];
        }
        return parent::load($data, $formName); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $arrTransSearchFields = [];
        foreach($this->installedLanguages as $language){
            $arrTransSearchFields[] = '_translations['.$language->code.']';
        }

        return [
            [['id'], 'integer'],
            [['category', 'message'], 'string'],
            [$arrTransSearchFields, 'safe']
        ];
    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
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
        $query = TextSource::find()->with('translations');

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
        ]);

        //conditions to find translations
        $i=0;
        if(!empty($this->_translations) && is_array($this->_translations)){
            foreach($this->_translations as $lang => $tran){
                $query->joinWith("translations t{$i}");
                $query->andWhere([ 'AND',
                    ["t{$i}.language" => $lang],
                    ['LIKE', "t{$i}.translation", $tran]
                ]);
                $i++;
            }
        }

        $query->andFilterWhere(['like', 'category', $this->category])
              ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
