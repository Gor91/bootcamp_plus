<?php

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = Yii::t('app', 'Create Person');
?>
<div class="learning-create">
    <?= $this->render('_form', compact('model', 'type_list', 'bootcamp_list', 'image')) ?>
</div>
