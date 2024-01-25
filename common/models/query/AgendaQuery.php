<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Agenda]].
 *
 * @see \common\models\Agenda
 */
class AgendaQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \common\models\Agenda[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Agenda|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $bootcamp_id
     * @return array|\common\models\Agenda[]
     */
    public function getByBootcampID($bootcamp_id)
    {
        $query = self::joinWith('agendaSpeakers')
            ->where(['agenda.bootcamp_id' => $bootcamp_id])
            ->orderBy(['date' => SORT_ASC, 'start_time' => SORT_ASC]);
        return $query->all();
    }
}
