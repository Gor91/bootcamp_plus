<?php

/* @var $this yii\web\View */
/* @var $model common\models\Logo */

$this->title = Yii::t('app', 'Create Logo For bootcamp');
?>
<div class="learning-create">
    <?= $this->render('_form', compact('model', 'model_image', 'bootcamp_list')) ?>
</div>
