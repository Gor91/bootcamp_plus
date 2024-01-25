<?php

namespace common\models;

use common\models\query\LogoQuery;
use Yii;

/**
 * This is the model class for table "bootcamp_logos".
 *
 * @property int $id
 * @property int $bootcamp_id
 * @property string $logo
 * @property string $link
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $bootcamps
 */
class Logo extends BaseModel
{
    public $bootcamps;

    public static function tableName()
    {
        return '{{%bootcamp_logos}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['link'], 'filter', 'filter' => 'trim'],
            [['link'], 'string', 'min' => 2, 'max' => 255],
            [['link'], 'url'],
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
            'link' => Yii::t('app', 'Link'),
            'logo' => Yii::t('app', 'Logo'),
            'bootcamp_id' => Yii::t('app', 'Bootcamp'),
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
     * @return LogoQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new LogoQuery(get_called_class());
    }
}
