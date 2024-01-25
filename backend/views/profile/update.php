<?php

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = Yii::t('app', 'Update Participant: {name}', [
    'name' => $model->company_name
]);
?>
<div class="learning-update">
    <?= $this->render('_form', compact('model', 'model_image', 'model_old_info_url', 'bootcamp_list')) ?>
</div>
