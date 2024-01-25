<?php

use common\widgets\Alert;
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

                <?= $form->field($model, 'link')->textInput() ?>

                <?= $form->field($model, 'category_id')->dropDownList($category_list) ?>

                <?= $form->field($image, 'image')->fileInput() ?>

                <?php if (isset($model->image) && $model->image): ?>
                    <div class="form-group">
                        <img src="<?= sprintf('%s/uploads/learning/%s', Yii::$app->params['frontendUrl'], $model->image); ?>"
                             alt="<?= $model->name ?>"
                             class='img-responsive'>
                    </div>
                <?php endif; ?>

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
