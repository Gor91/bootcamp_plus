<?php

use common\widgets\Alert;
use kartik\select2\Select2;
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
                <?= $form->field($model, 'fName')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'lName')->textInput() ?>

                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'position')->textInput() ?>

                <?= $form->field($model, 'company')->textInput() ?>

                <?= $form->field($model, 'link')->textInput() ?>

                <?= $form->field($model, 'bootcamps')->widget(Select2::class, [
                        'data' => $bootcamp_list,
                        'options' => [
                            'placeholder' => 'Select bootcamps...',
                            'multiple' => true,
                        ]
                    ]
                ) ?>

                <?= $form->field($model, 'type_id')->dropDownList($type_list) ?>

                <?= $form->field($model, 'order')->input('number') ?>

                <?= $form->field($image, 'image')->fileInput() ?>

                <?php if (isset($model->image) && $model->image): ?>
                    <div class="form-group">
                        <img src="<?= sprintf('%s/uploads/person/%s', Yii::$app->params['frontendUrl'], $model->image); ?>"
                             alt=""
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
