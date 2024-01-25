<?php

/* @var $this yii\web\View */
/* @var $model common\models\LearningCategory */
/* @var $image \common\components\FileUploader */

$this->title = Yii::t('app', 'Update Bootcamp: {name}', [
    'name' => $model->name,
]);

?>
<div class="bootcamp-update">
    <?= $this->render('_form', compact('model', 'bootcamp_list')) ?>
</div>
