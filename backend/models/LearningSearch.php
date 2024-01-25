<?php

namespace backend\models;

use common\models\Learning;
use yii\data\ActiveDataProvider;

class LearningSearch extends Learning
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'learning';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'order', 'link'], 'filter', 'filter' => 'trim'],
            [['category_id', 'order'], 'integer'],
        ];
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
        $query = Learning::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['category_id' => $this->category_id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
