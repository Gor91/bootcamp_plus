<?php

namespace backend\models;

use common\models\LearningCategory;
use yii\data\ActiveDataProvider;

class LearningCategorySearch extends LearningCategory
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'learning_category';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'order'], 'filter', 'filter' => 'trim'],
            [['bootcamp_id', 'order'], 'integer'],
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
        $query = LearningCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['bootcamp_id' => $this->bootcamp_id]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
