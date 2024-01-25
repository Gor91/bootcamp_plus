<?php

namespace common\models;

use common\models\query\AgendaMentorQuery;
use Yii;

/**
 * This is the model class for table "agenda_mentor".
 *
 * @property int $id
 * @property int $agenda_id
 * @property int $mentor_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Agenda $agenda
 * @property Person $mentor
 */
class AgendaMentor extends BaseModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['agenda_id', 'mentor_id'], 'required'],
            [['agenda_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agenda::class, 'targetAttribute' => ['agenda_id' => 'id']],
            [['mentor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['mentor_id' => 'id']]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'agenda_id' => Yii::t('app', 'Agenda ID'),
            'mentor_id' => Yii::t('app', 'Mentor ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgenda()
    {
        return $this->hasOne(Agenda::class, ['id' => 'agenda_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMentor()
    {
        return $this->hasOne(Person::class, ['id' => 'mentor_id']);
    }

    /**
     * @return AgendaMentorQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AgendaMentorQuery(get_called_class());
    }
}
