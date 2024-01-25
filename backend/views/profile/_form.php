<?php

use common\widgets\Alert;
use dosamigos\ckeditor\CKEditor;
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

                <?= $form->field($model, 'company_name')->textInput() ?>

                <?php if(isset($model_old_info_url)){?>
                    <?= Html::tag('p', Html::encode("Current file is ".$model_old_info_url)) ?>
                <?php }?>

                <?= $form->field($model_image, 'info_url')->fileInput() ?>

                <?= $form->field($model, 'bootcamp_id')->dropDownList($bootcamp_list) ?>

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
