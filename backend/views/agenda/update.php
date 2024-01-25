<?php

/* @var $this yii\web\View */
/* @var $model common\models\Agenda */

$this->title = Yii::t('app', 'Update Agenda: {name}', [
    'name' => $model->title,
]);
?>
<div class="agenda-update">
    <?= $this->render('_form', compact('model', 'person_list', 'bootcamp_list')) ?>
</div>
