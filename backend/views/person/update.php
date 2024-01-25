<?php

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = Yii::t('app', 'Update Person: {name}', [
    'name' => sprintf('%s %s', $model->fName, $model->lName),
]);
?>
<div class="learning-update">
    <?= $this->render('_form', compact('model', 'type_list', 'bootcamp_list', 'image')) ?>
</div>
