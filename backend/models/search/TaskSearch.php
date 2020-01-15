<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * TaskSearch represents the model behind the search form about `common\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @var
     */
    public $fund;
    /**
     * @var
     */
    public $owner;
    /**
     * @var
     */
    public $type;
    /**
     * @var
     */
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fund_id', 'owner_id', 'type_id'], 'integer'],
            [['properties','fund','owner','type'], 'safe'],
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
        $query = Task::find();

        $query->joinWith(['fund' => function($query) { $query->from(['fund' => 'founds']); }]);
        $query->joinWith(['owner' => function($query) { $query->from(['owner' => 'user']); }]);
        $query->joinWith(['type' => function($query) { $query->from(['type' => 'task_type']); }]);
        $query->joinWith(['taskStatuses' => function($query) { $query->from(['taskStatuses' => 'task_status']); }]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fund'] = [
            'asc' => ['fund.name' => SORT_ASC],
            'desc' => ['fund.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['owner'] = [
            'asc' => ['owner.username' => SORT_ASC],
            'desc' => ['owner.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['type'] = [
            'asc' => ['type.name' => SORT_ASC],
            'desc' => ['type.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['taskStatuses'] = [
            'asc' => ['taskStatuses.status' => SORT_ASC],
            'desc' => ['taskStatuses.status' => SORT_DESC],
        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'task.id' => $this->id,
            'fund_id' => $this->fund_id,
            'owner_id' => $this->owner_id,
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'properties', $this->properties])
            ->andFilterWhere(['like', 'fund.name', $this->fund])
            ->andFilterWhere(['like', 'owner.username', $this->owner])
            ->andFilterWhere(['like', 'type.name', $this->type])
        ;
        return $dataProvider;
    }
}
