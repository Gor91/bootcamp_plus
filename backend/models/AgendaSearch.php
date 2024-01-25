<?php

namespace backend\models;

use common\models\Agenda;
use yii\data\ActiveDataProvider;

class AgendaSearch extends Agenda
{
    public $start_date;
    public $end_date;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'agenda';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'date', 'start_time', 'end_time', 'content', 'order', 'video_url'], 'filter', 'filter' => 'trim'],
            [['bootcamp_id', 'order'], 'integer'],
            [['speakers', 'start_date', 'end_date'], 'safe'],
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
        $query = Agenda::find()->joinWith('agendaSpeakers');

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->start_date || $this->end_date) {
            $query->andFilterWhere(['between', 'date', $this->start_date, $this->end_date]);
        }

        $query->andFilterWhere(['agenda_speaker.speaker_id' => $this->speakers]);
        $query->andFilterWhere(['bootcamp_id' => $this->bootcamp_id]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'content', $this->content]);
        $query->andFilterWhere(['like', 'start_time', $this->start_time]);
        $query->andFilterWhere(['like', 'end_time', $this->end_time]);

        return $dataProvider;
    }
}
