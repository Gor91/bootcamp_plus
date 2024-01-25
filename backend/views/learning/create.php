<?php

/* @var $this yii\web\View */
/* @var $model common\models\Learning */

$this->title = Yii::t('app', 'Create Program');
?>
<div class="learning-create">
    <?= $this->render('_form', compact('model', 'category_list', 'image')) ?>

</div>
