<?php

use backend\models\Bootcamp;
use common\widgets\Alert;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BootcampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Boocamps List</h3>
                </div>
                <?php Alert::builder() ?>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'options' => ['class' => 'table-responsive'],
                        'filterPosition' => GridView::FILTER_POS_HEADER,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            [
                                'attribute' => 'start_date',
                                'format' => 'date',
                                'filter' => DateRangePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'start_date',
                                    'startAttribute' => 's_start_date',
                                    'endAttribute' => 's_end_date',
                                    'convertFormat' => true,
                                    'pluginOptions' => [
                                        'locale' => [
                                            'format' => 'Y-m-d',
                                            'separator' => ' to ',
                                        ]
                                    ]
                                ])
                            ],
                            [
                                'attribute' => 'end_date',
                                'format' => 'date',
                                'filter' => DateRangePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'end_date',
                                    'startAttribute' => 'e_start_date',
                                    'endAttribute' => 'e_end_date',
                                    'convertFormat' => true,
                                    'pluginOptions' => [
                                        'locale' => [
                                            'format' => 'Y-m-d',
                                            'separator' => ' to ',
                                        ]
                                    ]
                                ])
                            ],
                            [
                                'attribute' => 'status_id',
                                'format' => 'html',
                                'filter' => Bootcamp::statusList(),
                                'value' => function ($model) {
                                    if ($model->status_id == \common\models\Bootcamp::STATUS_ACTIVE) {
                                        return '<span class="label label-success">Active</span>';
                                    }
                                    return '<span class="label label-warning">Inactive</span>';

                                },
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'datetime',
                                'filter' => false
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format' => 'datetime',
                                'filter' => false
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'contentOptions' => ['style' => 'min-width:175px'],
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::a('Update', $url, [
                                            'class' => 'btn bg-aqua btn-xs',
                                        ]);
                                    },
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
