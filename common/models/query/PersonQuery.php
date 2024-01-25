<?php

namespace common\models\query;

use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\common\models\Person]].
 *
 * @see \common\models\Person
 */
class PersonQuery extends \yii\db\ActiveQuery
{
    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $id
     * @return array
     */
    public function getBootcampListById($id)
    {
        $query = self::joinWith('bootcampPersons');
        $query->where(['person_id' => $id]);
        $query->select(['bootcamp.id', 'name']);

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * @param $id
     * @return array
     */
    public function getByAgendaID($id)
    {
        $query = self::joinWith('agendaSpeakers');
        $query->where(['agenda_id' => $id]);
        $query->select(["person.id, CONCAT(`fName`,' ',`lName`) as name"]);

        return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
    }

    /**
     * @param $id
     * @return array
     */
    public function getMentorsByAgendaID($id)
    {
        $query = self::joinWith('agendaMentors');
        $query->where(['agenda_id' => $id]);
        $query->select(["person.id, CONCAT(`fName`,' ',`lName`) as name"]);

        return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    public function getList()
    {
        $query = self::select(["id, CONCAT(`fName`,' ',`lName`) as name"])->asArray()->all();

        if ($query) {
            return ArrayHelper::map($query, 'id', 'name');
        }

        return [];
    }

    /**
     * @param int $byType
     * @return int|string
     */
    public function getCount($byType = 0)
    {
        if ($byType) {
            return self::where(['type_id' => $byType])->count();
        }

        return self::count();
    }

    /**
     * @param $bootcamp_id
     * @param int $person_type_id [PersonType::MENTOR,PersonType::SPEAKER]
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getByBootcampID($bootcamp_id, $person_type_id = 0)
    {
        $query = self::joinWith('bootcampPersons')->where(['bootcamp_id' => $bootcamp_id]);

        if ($person_type_id) {
            $query->andWhere(['type_id' => $person_type_id]);
        }

        return $query->all();
    }
}
