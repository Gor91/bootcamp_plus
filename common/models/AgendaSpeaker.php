<?php

namespace common\models;

use common\models\query\AgendaSpeakerQuery;
use Yii;

/**
 * This is the model class for table "agenda_speaker".
 *
 * @property int $id
 * @property int $agenda_id
 * @property int $speaker_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Agenda $agenda
 * @property Person $speaker
 */
class AgendaSpeaker extends BaseModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['agenda_id', 'speaker_id'], 'required'],
            [['agenda_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agenda::class, 'targetAttribute' => ['agenda_id' => 'id']],
            [['speaker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['speaker_id' => 'id']],
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
            'speaker_id' => Yii::t('app', 'Speaker ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Agenda]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AgendaQuery
     */
    public function getAgenda()
    {
        return $this->hasOne(Agenda::class, ['id' => 'agenda_id']);
    }

    /**
     * Gets query for [[Speaker]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PersonQuery
     */
    public function getSpeaker()
    {
        return $this->hasOne(Person::class, ['id' => 'speaker_id']);
    }

    /**
     * @return AgendaSpeakerQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AgendaSpeakerQuery(get_called_class());
    }
}
