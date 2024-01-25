<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Gallery]].
 *
 * @see \common\models\GalleryQuery
 */
class GalleryQuery extends \yii\db\ActiveQuery
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
     * @param $bootcamp_id
     * @param int $person_type_id [PersonType::MENTOR,PersonType::SPEAKER]
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getByBootcampID($bootcamp_id)
    {
        $query = self::where(['bootcamp_id'=>$bootcamp_id])->orderBy(['order' => SORT_DESC]);

        return $query->all();
    }
}
