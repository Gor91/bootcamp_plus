<?php

/* @var $this yii\web\View */
/* @var $model common\models\Bootcamp */
/* @var $image \common\components\FileUploader */

$this->title = Yii::t('app', 'Create Bootcamp');
?>
<div class="bootcamp-create">
    <?= $this->render('_form', compact('model', 'image', 'header_image', 'document', 'organizer_image')) ?>

</div>
