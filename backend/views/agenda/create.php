<?php

/* @var $this yii\web\View */
/* @var $model common\models\Agenda */

$this->title = Yii::t('app', 'Create Agenda');
?>
<div class="learning-create">
    <?= $this->render('_form', compact('model', 'person_list', 'bootcamp_list')) ?>
</div>
