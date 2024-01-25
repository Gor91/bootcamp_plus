<?php

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = Yii::t('app', 'Create Participant');
?>
<div class="learning-create">
    <?= $this->render('_form', compact('model', 'model_image', 'bootcamp_list')) ?>
</div>
