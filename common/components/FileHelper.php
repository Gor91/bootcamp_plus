<?php
/**
 * FileHelper
 *
 */

namespace common\components;

use yii;

class FileHelper extends yii\helpers\FileHelper
{
    /**
     * This method deletes file from passed path.
     * @param String $file
     * @return bool
     */
    public static function deleteFile($file)
    {
        if (is_file($file)) {
            return @unlink($file);
        }
        return false;
    }
}