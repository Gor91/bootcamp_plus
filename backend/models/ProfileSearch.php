<?php

namespace backend\models;

use common\models\Profile;
use yii\data\ActiveDataProvider;

class ProfileSearch extends Profile
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['company_name'], 'filter', 'filter' => 'trim'],
            ['bootcamp_id', 'integer'],
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
        $query = Profile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['bootcamp_id' => $this->bootcamp_id]);
        $query->andFilterWhere(['like', 'company_name', $this->company_name]);

        return $dataProvider;
    }
}
