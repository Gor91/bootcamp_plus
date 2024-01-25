<?php

use common\models\Person;
use common\widgets\Alert;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;

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
                                'attribute' => 'logo',
                                'format' => 'html',
                                'value' => function ($model) {
                                    return sprintf("<img src='%s/uploads/logo/%s' class='img-responsive' style='width: 100px;'>",Yii::$app->params['frontendUrl'], $model->logo);
                                },
                            ],
                            'link',
                            [
                                'attribute' => 'bootcamp_id',
                                'value' => function ($model) {
                                    return $model->bootcamp->name;
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
