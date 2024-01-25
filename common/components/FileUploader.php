<?php
/**
 * FileUploader
 */

namespace common\components;

use yii\base\Model;
use yii\web\UploadedFile;

class FileUploader extends Model
{
    /**@var string $SCENARIO_IMAGE */
    const SCENARIO_IMAGE = 'image';

    /**@var string $BOOTCAMP_LOGO */
    const BOOTCAMP_LOGO = 'bootcamp_logo';

    /**@var UploadedFile $image */
    public $image;

    /**@var UploadedFile $header_image */
    public $header_image;

    /**@var UploadedFile $organizer_image */
    public $organizer_image;

    /**@var UploadedFile $document */
    public $document;

    /**@var UploadedFile $logo */
    public $logo;

    /**@var UploadedFile $info_url */
    public $info_url;
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['image', 'required', 'on' => [self::SCENARIO_IMAGE]],
            ['logo', 'required', 'on' => [self::BOOTCAMP_LOGO]],
            [['info_url'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, docx', 'maxFiles' => 1],
            [['image', 'header_image', 'organizer_image', 'logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 1, 'maxSize' => 1024 * 1024 * 10],
            ['document', 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxFiles' => 1, 'maxSize' => 1024 * 1024 * 25],
        ];
    }
}