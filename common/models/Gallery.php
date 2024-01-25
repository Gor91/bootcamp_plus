<?php

namespace common\models;

use common\models\query\GalleryQuery;
use Yii;

/**
 * This is the model class for table "bootcamp_gallery".
 *
 * @property int $id
 * @property int $bootcamp_id
 * @property string $image
 * @property int $order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $bootcamps
 */
class Gallery extends BaseModel
{
    public $bootcamps;

    public static function tableName()
    {
        return '{{%bootcamp_gallery}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['order'], 'integer'],
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
            'image' => Yii::t('app', 'Logo'),
            'order' => Yii::t('app', 'Order'),
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
     * @return GalleryQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new GalleryQuery(get_called_class());
    }
}
