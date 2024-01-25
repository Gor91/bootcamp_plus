<?php

namespace common\models;

use common\models\query\BootcampQuery;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "bootcamp".
 *
 * @property int $id
 * @property string $name
 * @property int $status_id
 * @property string $slug
 * @property string $start_date
 * @property string $end_date
 * @property string $header_image
 * @property string $image
 * @property string $organizer_image
 * @property string $document
 * @property string $about
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Agenda[] $agendas
 * @property LearningCategory[] $learningCategories
 * @property Profile[] $profiles
 */
class Bootcamp extends BaseModel
{
    const CURRENT = 'current';
    const NEXT = 'next';
    const LAST = 'last';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name'
            ]
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'start_date', 'end_date', 'about', 'status_id'], 'filter', 'filter' => 'trim'],
            [['name', 'start_date', 'end_date', 'about'], 'required'],
            ['status_id', 'in', 'allowArray' => true, 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>='],
            [['name', 'slug', 'document'], 'string', 'max' => 255, 'min' => 2],
            ['about', 'string'],
            [['name', 'slug'], 'unique']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status_id' => Yii::t('app', 'Status'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'image' => Yii::t('app', 'Image'),
            'header_image' => Yii::t('app', 'Header Image'),
            'about' => Yii::t('app', 'About'),
            'document' => Yii::t('app', 'Document'),
            'organizer_image' => Yii::t('app', 'Organizer image'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendas()
    {
        return $this->hasMany(Agenda::class, ['bootcamp_id' => 'id']);
    }

    /**
     * Gets query for [[LearningCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\LearningCategoryQuery
     */
    public function getLearningCategories()
    {
        return $this->hasMany(Learning::class, ['category_id' => 'id'])->viaTable('{{%learning_category}}', ['bootcamp_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProfileQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::class, ['bootcamp_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPersons()
    {
        return $this->hasMany(Person::class, ['id' => 'person_id'])->viaTable('{{%person_bootcamp}}', ['bootcamp_id' => 'id']);
    }

    /**
     * @param $start
     * @param $end
     */
    function dateRanges($start, $end)
    {
        $startTime = strtotime($start);
        $endTime = strtotime($end);

        if (date('Y', $startTime) != date('Y', $endTime)) {
            echo date('F j, Y', $startTime) . " - " . date('F j, Y', $endTime);
        } else {
            if ((date('j', $startTime) == 1) && (date('j', $endTime) == date('t', $endTime))) {
                echo date('F', $startTime) . " - " . date('F, Y', $endTime);
            } else {
                if (date('m', $startTime) != date('m', $endTime)) {
                    echo date('F j', $startTime) . " - " . date('F j, Y', $endTime);
                } else {
                    echo date('F j', $startTime) . " - " . date('j, Y', $endTime);
                }
            }
        }
    }

    /**
     * @return array
     */
    public static function statusList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogos()
    {
        return $this->hasMany(Logo::class, ['bootcamp_id' => 'id']);
    }


    /**
     * @return BootcampQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new BootcampQuery(get_called_class());
    }
}
