<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Learning]].
 *
 * @see \common\models\Learning
 */
class LearningQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \common\models\Learning[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Learning|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
