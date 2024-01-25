<?php

namespace common\models\query;

use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\common\models\LearningCategory]].
 *
 * @see \common\models\LearningCategory
 */
class LearningCategoryQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \common\models\LearningCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\LearningCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public function getList()
    {
        $query = $this->all();

        if ($query) {
            return ArrayHelper::map($query, 'id', 'name');
        }

        return [];
    }

    /**
     * @param $bootcamp_id
     * @return array|\common\models\LearningCategory[]
     */
    public function getByBootcampID($bootcamp_id)
    {
        $query = self::where(['bootcamp_id' => $bootcamp_id])
            ->joinWith(['learnings']);

        return $query->all();
    }
}
