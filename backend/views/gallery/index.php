<?php

use common\models\Person;
use common\widgets\Alert;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
///* @var $searchModel backend\models\ */
///* @var $dataProvider yii\data\ActiveDataProvider */

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Logo List</h3>
                </div>
                <?php Alert::builder();
                ?>
                <!-- /.box-header -->

                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'table-responsive'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'image',
                                'format' => 'html',
                                'value' => function ($model) {
                                    return sprintf("<img src='%s/uploads/gallery/%s' class='img-responsive' style='width: 100px;'>",Yii::$app->params['frontendUrl'], $model->image);
                                },
                            ],
                            [
                                'attribute' => 'bootcamp_id',
                                'value' => function ($model) {
                                    return $model->bootcamp->name;
                                },
                            ],
                            [
                                'attribute' => 'order',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $form = sprintf("
                                    <form id='order-form' action='/gallery/%d/order' method='post'>
                                        <input type='hidden' name='%s' value='%s'>
                                        <input type='number' name='order' value='%d'>
                                        <button type='submit'>save</button>
                                    </form>", $model->id, Yii::$app->request->csrfParam, Yii::$app->request->csrfToken, $model->order
                                    );

                                  return $form;
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{delete}',
                                'contentOptions' => ['style' => 'min-width:175px'],
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('Delete', $url, [
                                            'class' => 'btn btn-danger btn-xs',
                                            'data-confirm' => 'Are you sure you want to delete?'
                                        ]);
                                    },
                                ],
                            ]
                        ]
                    ]) ?>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
