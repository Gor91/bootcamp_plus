<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Profile]].
 *
 * @see \common\models\Profile
 */
class ProfileQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \common\models\Profile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Profile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $bootcamp_id
     * @return array|\common\models\Profile[]
     */
    public function getByBootcampID($bootcamp_id)
    {
        $query = self::where(['bootcamp_id' => $bootcamp_id]);

        return $query->all();
    }
}
