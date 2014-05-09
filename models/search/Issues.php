<?php

namespace nitm\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use nitm\models\Issues as IssuesModel;

/**
 * Issues represents the model behind the search form about `app\models\Issues`.
 */
class Issues extends IssuesModel
{
    public function rules()
    {
        return [
            [['id', 'parent_id', 'resolved', 'author', 'closed_by', 'resolved_by', 'closed', 'duplicate', 'duplicate_id'], 'integer'],
            [['parent_type', 'notes', 'created_at', 'resolved_at', 'closed_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = IssuesModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		$params = isset($params[$this->formName()]) ? $params : [$this->formName() => $params];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'resolved' => $this->resolved,
            'created_at' => $this->created_at,
            'author' => $this->author,
            'closed_by' => $this->closed_by,
            'resolved_by' => $this->resolved_by,
            'resolved_at' => $this->resolved_at,
            'closed' => $this->closed,
            'closed_at' => $this->closed_at,
            'duplicate' => $this->duplicate,
            'duplicate_id' => $this->duplicate_id,
        ]);

        $query->andFilterWhere(['like', 'parent_type', $this->parent_type])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
