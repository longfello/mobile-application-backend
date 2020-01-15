<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Founds;

/**
 * FoundsSearch represents the model behind the search form about `common\models\Founds`.
 */
class FoundsSearch extends Founds
{
    /**
     * @var
     */
    public $country;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country_id'], 'integer'],
            [['name', 'logo_path', 'logo_base_url', 'banner_path', 'banner_base_url', 'href', 'description','country'], 'safe'],
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
        $query = Founds::find();

        $query->joinWith(['country' => function($query) { $query->from(['country' => 'country']); }]);
        $query->joinWith(['tasks' => function($query) { $query->from(['tasks' => 'task']); }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['country'] = [
            'asc' => ['country.name' => SORT_ASC],
            'desc' => ['country.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'founds.id' => $this->id,
//            'country_id' => $this->country_id,
        ]);

        $query->andFilterWhere(['like', 'founds.name', $this->name])
//            ->andFilterWhere(['like', 'logo_path', $this->logo_path])
//            ->andFilterWhere(['like', 'logo_base_url', $this->logo_base_url])
//            ->andFilterWhere(['like', 'banner_path', $this->banner_path])
//            ->andFilterWhere(['like', 'banner_base_url', $this->banner_base_url])
            ->andFilterWhere(['like', 'founds.href', $this->href])
            ->andFilterWhere(['like', 'country.name', $this->country])
            ->andFilterWhere(['like', 'founds.description', $this->description]);

        return $dataProvider;
    }
}
