<?php

use common\widgets\Alert;
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="row">
    <!-- left column -->
    <div class="col-md-6 col-md-offset-3">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title ?></h3>
            </div>
            <?php Alert::builder() ?>

            <?php $form = ActiveForm::begin(['id' => 'create-form']); ?>
            <div class="box-body">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
                    'name' => 'dp_1',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>

                <?= $form->field($model, 'end_date')->widget(DatePicker::class, [
                    'name' => 'dp_2',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>

                <?= $form->field($model, 'about')->widget(CKEditor::class, [
                    'options' => ['rows' => 6, 'class' => 'post-description'],
                    'clientOptions' => ['allowedContent' => true]
                ]) ?>

                <?= $form->field($document, 'document')->fileInput() ?>

                <?php if (isset($model->document) && $model->document): ?>
                    <div class="form-group">
                        <a href="<?= sprintf('%s/uploads/bootcamp/document/%s', Yii::$app->params['frontendUrl'], $model->document); ?>"

                           class='img-responsive'><?= $model->document ?></a>
                    </div>
                <?php endif; ?>

                <?= $form->field($image, 'image')->fileInput() ?>

                <?php if (isset($model->image) && $model->image): ?>
                    <div class="form-group">
                        <img src="<?= sprintf('%s/uploads/bootcamp/%s', Yii::$app->params['frontendUrl'], $model->image); ?>"
                             alt="<?= $model->name ?>"
                             class='img-responsive'>
                    </div>
                <?php endif; ?>

                <?= $form->field($header_image, 'header_image')->fileInput() ?>

                <?php if (isset($model->header_image) && $model->header_image): ?>
                    <div class="form-group">
                        <img src="<?= sprintf('%s/uploads/bootcamp/header/%s', Yii::$app->params['frontendUrl'], $model->header_image); ?>"
                             alt="<?= $model->name ?>"
                             class='img-responsive'>
                    </div>
                <?php endif; ?>

                <?= $form->field($organizer_image, 'organizer_image')->fileInput() ?>
                <?php if (isset($model->organizer_image) && $model->organizer_image): ?>
                    <div class="form-group">
                        <img src="<?= sprintf('%s/uploads/bootcamp/organizer/%s', Yii::$app->params['frontendUrl'], $model->organizer_image); ?>"
                             alt="<?= $model->name ?>"
                             class='img-responsive'>
                    </div>
                <?php endif; ?>

                <?= $form->field($model, 'status_id')->dropDownList(\common\models\Bootcamp::statusList()) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"></i> Add' : '<i class="fa fa-edit"></i> Update', ['class' => 'btn btn-info btn-block btn-flat']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.box -->

    </div>
    <!--/.col (left) -->
</div>
