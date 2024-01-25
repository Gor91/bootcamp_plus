<?php

namespace backend\models;

use yii\data\ActiveDataProvider;

class PersonSearch extends Person
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['fName', 'lName', 'email', 'position', 'company', 'link'], 'filter', 'filter' => 'trim'],
            [['type_id', 'bootcamps'], 'safe'],
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
        $query = Person::find()->joinWith('bootcampPersons');

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['person_bootcamp.bootcamp_id' => $this->bootcamps]);
        $query->andFilterWhere(['type_id' => $this->type_id]);
        $query->andFilterWhere(['like', 'fName', $this->fName]);
        $query->andFilterWhere(['like', 'lName', $this->lName]);
        $query->andFilterWhere(['like', 'position', $this->position]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'company', $this->company]);
        $query->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
