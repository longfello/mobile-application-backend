<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TaskStatus;

/**
 * TaskStatusSearch represents the model behind the search form about `common\models\TaskStatus`.
 */
class TaskStatusSearch extends TaskStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'integer'],
            [['status'], 'safe'],
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
        $query = TaskStatus::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
