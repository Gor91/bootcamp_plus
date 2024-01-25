<?php

/* @var $this yii\web\View */
/* @var $model common\models\Learning */

$this->title = Yii::t('app', 'Update Program: {name}', [
    'name' => $model->name,
]);
?>
<div class="learning-update">
    <?= $this->render('_form', compact('model', 'category_list', 'image')) ?>

</div>
