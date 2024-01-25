<?php

namespace common\models;

use common\models\query\ProfileQuery;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int|null $bootcamp_id
 * @property string $company_name
 * @property string $info_url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Bootcamp $bootcamp
 * @property ProfileVideo[] $profileVideos
 */
class Profile extends BaseModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['company_name'], 'filter', 'filter' => 'trim'],
            [['company_name'], 'required'],
            [['company_name','info_url'], 'string', 'min' => 2, 'max' => 255],
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
            'company_name' => Yii::t('app', 'Company Name'),
            'info_url' => Yii::t('app', 'Info url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
     * Gets query for [[ProfileVideos]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProfileVideoQuery
     */
    public function getProfileVideos()
    {
        return $this->hasMany(ProfileVideo::class, ['profile_id' => 'id']);
    }

    /**
     * @return ProfileQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
}
