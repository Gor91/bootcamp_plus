<?php

namespace common\models;

use common\models\query\LearningQuery;
use Yii;

/**
 * This is the model class for table "learning".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $image
 * @property string|null $link
 * @property int|null $order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LearningCategory $category
 */
class Learning extends BaseModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'order'], 'filter', 'filter' => 'trim'],
            [['category_id', 'name'], 'required'],
            [['name'], 'string', 'min' => 2, 'max' => 255],
            [['order'], 'integer', 'min' => 0],
            ['link', 'url'],
            ['name', 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningCategory::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category'),
            'name' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Image'),
            'link' => Yii::t('app', 'Link'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\LearningCategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(LearningCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return LearningQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new LearningQuery(get_called_class());
    }
}
