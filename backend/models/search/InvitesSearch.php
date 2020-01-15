<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invites;

/**
 * InvitesSearch represents the model behind the search form about `common\models\Invites`.
 */
class InvitesSearch extends Invites
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'integer'],
            [['status', 'sended'], 'safe'],
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
        $query = Invites::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
            'sended' => $this->sended,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
