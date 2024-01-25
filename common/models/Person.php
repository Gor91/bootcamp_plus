<?php

namespace common\models;

use common\models\query\AgendaMentorQuery;
use common\models\query\PersonQuery;
use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property int|null $type_id
 * @property string $fName
 * @property string $lName
 * @property string $email
 * @property string $position
 * @property string $company
 * @property string $image
 * @property string|null $link
 * @property int|null $order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $bootcamps
 *
 * @property AgendaSpeaker[] $agendaSpeakers
 * @property AgendaMentor[] $agendaMentors
 * @property PersonType $type
 */
class Person extends BaseModel
{
    public $bootcamps;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['fName', 'lName', 'email', 'position', 'company', 'link'], 'filter', 'filter' => 'trim'],
            [['fName', 'lName', 'position', 'bootcamps'], 'required'],
            ['order', 'integer', 'min' => 0],
            ['link', 'url'],
            ['email', 'email'],
            ['type_id', 'in', 'allowArray' => true, 'range' => [PersonType::MENTOR, PersonType::SPEAKER]],
            ['bootcamps', 'in', 'allowArray' => true, 'range' => array_keys(Bootcamp::find()->getList())],
            [['fName', 'lName', 'email', 'position', 'company', 'link'], 'string', 'min' => 2, 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_id' => Yii::t('app', 'Type'),
            'fName' => Yii::t('app', 'First Name'),
            'lName' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'position' => Yii::t('app', 'Position'),
            'company' => Yii::t('app', 'Company'),
            'image' => Yii::t('app', 'Image'),
            'link' => Yii::t('app', 'Link'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[AgendaSpeakers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AgendaSpeakerQuery
     */
    public function getAgendaSpeakers()
    {
        return $this->hasMany(AgendaSpeaker::class, ['speaker_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendaMentors()
    {
        return $this->hasMany(AgendaMentor::class, ['mentor_id' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PersonTypeQuery
     */
    public function getType()
    {
        return $this->hasOne(PersonType::class, ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getBootcampPersons()
    {
        return $this->hasMany(Bootcamp::class, ['id' => 'bootcamp_id'])->viaTable('{{%person_bootcamp}}', ['person_id' => 'id']);
    }

    /**
     * @return PersonQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }
}
