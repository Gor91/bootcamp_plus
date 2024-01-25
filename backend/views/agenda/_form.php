<?php

use common\widgets\Alert;
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
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
                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'date')->widget(DatePicker::class, [
                    'name' => 'dp_1',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]

                ]) ?>

                <?= $form->field($model, 'start_time')->textInput(['placeholder'=>'Format: ex. 15:15']) ?>

                <?= $form->field($model, 'end_time')->textInput(['placeholder'=>'Format: ex. 15:15']) ?>

                <?= $form->field($model, 'video_url')->textInput(['placeholder'=>'http//']) ?>

                <?= $form->field($model, 'speakers')->widget(Select2::class, [
                        'data' => $person_list,
                        'options' => [
                            'placeholder' => 'Select speakers...',
                            'multiple' => true
                        ]
                    ]
                ) ?>

                <?= $form->field($model, 'mentors')->widget(Select2::class, [
                        'data' => $person_list,
                        'options' => [
                            'placeholder' => 'Select mentors...',
                            'multiple' => true
                        ]
                    ]
                ) ?>

                <?= $form->field($model, 'bootcamp_id')->dropDownList($bootcamp_list) ?>

                <?= $form->field($model, 'content')->widget(CKEditor::class, [
                    'options' => ['rows' => 6, 'class' => 'Description'],
                    'clientOptions' => ['allowedContent' => true]
                ]) ?>

                <?= $form->field($model, 'order')->input('number') ?>

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
