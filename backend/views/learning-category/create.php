<?php

/* @var $this yii\web\View */
/* @var $model common\models\LearningCategory */
/* @var $bootcamp_list array */

$this->title = Yii::t('app', 'Create program category');
?>
<div class="bootcamp-create">
    <?= $this->render('_form', compact('model', 'bootcamp_list')) ?>

</div>
