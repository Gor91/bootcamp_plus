<?php

namespace common\models;

use common\models\query\AgendaQuery;
use Yii;

/**
 * This is the model class for table "agenda".
 *
 * @property int $id
 * @property int|null $bootcamp_id
 * @property string $title
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string $content
 * @property int|null $order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Bootcamp $bootcamp
 * @property AgendaSpeaker[] $agendaSpeakers
 */
class Agenda extends BaseModel
{
    public $speakers;
    public $mentors;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'date', 'start_time', 'end_time', 'content', 'order', 'video_url'], 'filter', 'filter' => 'trim'],
            ['order', 'integer', 'min' => 0],
            [['title', 'date', 'start_time', 'end_time', 'content'], 'required'],
            ['content', 'string'],
            [['title','video_url'], 'string', 'max' => 255],
            ['speakers', 'in', 'allowArray' => true, 'range' => array_keys(Person::find()->getList())],
            ['mentors', 'in', 'allowArray' => true, 'range' => array_keys(Person::find()->getList())],
            ['date', 'date', 'format' => 'php:Y-m-d'],
            [['start_time', 'end_time'], 'date', 'format' => 'php:H:i'],
            ['end_time', 'compare', 'compareAttribute' => 'start_time', 'operator' => '>='],
            ['bootcamp_id', 'exist', 'skipOnError' => true, 'targetClass' => Bootcamp::class, 'targetAttribute' => ['bootcamp_id' => 'id']],
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
            'title' => Yii::t('app', 'Title'),
            'date' => Yii::t('app', 'Date'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'content' => Yii::t('app', 'Content'),
            'video_url' => Yii::t('app', 'Video Url'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBootcamp()
    {
        return $this->hasOne(Bootcamp::class, ['id' => 'bootcamp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getAgendaSpeakers()
    {
        return $this->hasMany(Person::class, ['id' => 'speaker_id'])->viaTable('{{%agenda_speaker}}', ['agenda_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getAgendaMentors()
    {
        return $this->hasMany(Person::class, ['id' => 'mentor_id'])->viaTable('{{%agenda_mentor}}', ['agenda_id' => 'id']);
    }

    /**
     * @return AgendaQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AgendaQuery(get_called_class());
    }
}
