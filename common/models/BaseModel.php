<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * BaseModel model
 *
 * @property integer $created_at
 * @property integer $updated_at
 */
class BaseModel extends ActiveRecord
{
    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
        }

        $this->updated_at = time();
        return parent::beforeSave($insert);
    }
}