<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change password';
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-6 col-md-offset-3">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Change password</h3>
            </div>
            <?php Alert::builder() ?>
            <!-- /.box-header -->
            <!-- form start -->

            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <?= $form->field($model, 'password')->passwordInput()->label('New paswword'); ?>
                <?= $form->field($model, 'confirmPassword')->passwordInput()->label('Confirm password'); ?>
                <div class="form-group">
                    <?= Html::submitButton('Change', ['class' => 'btn btn-info']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
        <!-- /.box -->
    </div>
    <!--/.col (left) -->
</div>
