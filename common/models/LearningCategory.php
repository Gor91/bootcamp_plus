<?php

namespace common\models;

use common\models\query\LearningCategoryQuery;
use Yii;

/**
 * This is the model class for table "learning_category".
 *
 * @property int $id
 * @property int|null $bootcamp_id
 * @property string $name
 * @property int|null $order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Learning[] $learnings
 * @property Bootcamp $bootcamp
 */
class LearningCategory extends BaseModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'order'], 'filter', 'filter' => 'trim'],
            [['name', 'bootcamp_id'], 'required'],
            ['name', 'string', 'max' => 255, 'min' => 2],
            ['order', 'integer', 'min' => 0],
            [['bootcamp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bootcamp::class, 'targetAttribute' => ['bootcamp_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bootcamp_id' => Yii::t('app', 'Bootcamp'),
            'name' => Yii::t('app', 'Name'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Learnings]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\LearningQuery
     */
    public function getLearnings()
    {
        return $this->hasMany(Learning::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Bootcamp]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BootcampQuery
     */
    public function getBootcamp()
    {
        return $this->hasOne(Bootcamp::class, ['id' => 'bootcamp_id']);
    }

    /**
     * @return LearningCategoryQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new LearningCategoryQuery(get_called_class());
    }
}
