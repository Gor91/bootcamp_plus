<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Bootcamp */
/* @var $image \common\components\FileUploader */

$this->title = Yii::t('app', 'Update Bootcamp: {name}', [
    'name' => $model->name,
]);

?>
<div class="bootcamp-update">
    <?= $this->render('_form', compact('model', 'image', 'header_image', 'document', 'organizer_image')) ?>
</div>
