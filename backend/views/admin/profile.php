<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\Admin */

use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change profile';
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-6 col-md-offset-3">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Profile info</h3>
            </div>
            <?php Alert::builder() ?>
            <!-- /.box-header -->

            <!-- form start -->
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Name']) ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail']) ?>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                <?= Html::a('Change password', '/change-password', ['class' => 'btn btn-info pull-right']) ?>
            </div>
            <?php $form = ActiveForm::end(); ?>
        </div>
        <!-- /.box -->

    </div>
    <!--/.col (left) -->
</div>
