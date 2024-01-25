<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "person_bootcamp".
 *
 * @property int $id
 * @property int $person_id
 * @property int $bootcamp_id
 */
class PersonBootcamp extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['person_id', 'bootcamp_id'], 'required'],
            [['person_id', 'bootcamp_id'], 'unique', 'targetAttribute' => ['person_id', 'bootcamp_id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['person_id' => 'id']],
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
            'person_id' => Yii::t('app', 'Person'),
            'bootcamp_id' => Yii::t('app', 'Bootcamp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBootcamp()
    {
        return $this->hasOne(Bootcamp::class, ['id' => 'bootcamp_id']);
    }
}
