<?php
/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name;

?>
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b><?= $this->title ?></b> </a></div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php Alert::builder() ?>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => '/login',]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'E-mail',])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-info btn-block btn-flat']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.login-box-body -->
</div>