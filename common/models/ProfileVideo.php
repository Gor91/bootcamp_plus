<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_video".
 *
 * @property int $id
 * @property int|null $profile_id
 * @property string $path
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Profile $profile
 */
class ProfileVideo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'created_at', 'updated_at'], 'integer'],
            [['path', 'created_at', 'updated_at'], 'required'],
            [['path'], 'string', 'max' => 255],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'profile_id' => Yii::t('app', 'Profile ID'),
            'path' => Yii::t('app', 'Path'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProfileQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProfileVideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProfileVideoQuery(get_called_class());
    }
}
