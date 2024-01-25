<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Bootcamp;

/**
 * BootcampSearch represents the model behind the search form of `common\models\Bootcamp`.
 */
class BootcampSearch extends Bootcamp
{
    public $s_start_date;
    public $s_end_date;
    public $e_start_date;
    public $e_end_date;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'bootcamp';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'start_date', 'end_date', 'status_id'], 'safe'],
            [['s_start_date', 's_end_date', 'e_start_date', 'e_end_date'], 'date', 'format' => 'php:Y-m-d'],
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
        $query = Bootcamp::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->s_start_date || $this->s_end_date) {
            $query->andFilterWhere(['between', 'start_date', $this->s_start_date, $this->s_end_date]);
        }

        if ($this->e_start_date || $this->e_end_date) {
            $query->andFilterWhere(['between', 'end_date', $this->e_start_date, $this->e_end_date]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['status_id' => $this->status_id]);

        return $dataProvider;
    }
}
