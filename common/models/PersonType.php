<?php

namespace common\models;

use common\models\query\PersonTypeQuery;
use Yii;

/**
 * This is the model class for table "person_type".
 *
 * @property int $id
 * @property string $title
 *
 * @property Person[] $people
 */
class PersonType extends \yii\db\ActiveRecord
{
    const MENTOR = 1;
    const SPEAKER = 2;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * Gets query for [[People]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PersonQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::class, ['type_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return [
            self::MENTOR => 'Mentor',
            self::SPEAKER => 'Speaker'
        ];
    }

    /**
     * @return PersonTypeQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new PersonTypeQuery(get_called_class());
    }
}
