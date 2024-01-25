<?php

namespace common\models\query;

use common\models\Bootcamp;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\common\models\Bootcamp]].
 *
 * @see \common\models\Bootcamp
 */
class BootcampQuery extends \yii\db\ActiveQuery
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
     * @param $slug
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getBySlug($slug)
    {
        $query = self::joinWith(['profiles'])
            ->joinWith(['persons'])
            ->with('learningCategories')
            ->andWhere(["slug" => $slug])
            ->andWhere(['status_id' => Bootcamp::STATUS_ACTIVE]);

        return $query->one();
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getNextOrCurrent()
    {
        $current_date = date('Y-m-d');

        $query = self::where(['<=', 'start_date', $current_date])
            ->andWhere(['>=', 'end_date', $current_date])
            ->andWhere(['status_id' => Bootcamp::STATUS_ACTIVE]);

        if ($query->exists()) {
            return [
                'period' => Bootcamp::CURRENT,
                'data' => $query->one()
            ];
        }

        $query = self::where(['>=', 'start_date', $current_date])
            ->andWhere(['status_id' => Bootcamp::STATUS_ACTIVE])
            ->orderBy(['start_date' => SORT_ASC]);

        if ($query->exists()) {
            return [
                'period' => Bootcamp::NEXT,
                'data' => $query->one()
            ];
        }

        $query = self::where(['status_id' => Bootcamp::STATUS_ACTIVE])
            ->orderBy(['end_date' => SORT_DESC]);

        if ($query->exists()) {
            return [
                'period' => Bootcamp::LAST,
                'data' => $query->one()
            ];
        }

        return null;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getActive()
    {
        return self::where(['status_id' => Bootcamp::STATUS_ACTIVE])->all();
    }
}
