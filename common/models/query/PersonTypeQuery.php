<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\PersonType]].
 *
 * @see \common\models\PersonType
 */
class PersonTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\PersonType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\PersonType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
