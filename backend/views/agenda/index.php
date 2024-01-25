<?php

use common\models\Person;
use common\widgets\Alert;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AgendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Agenda List</h3>
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
                            'title',
                            [
                                'attribute' => 'date',
                                'format' => 'date',
                                'filter' => DateRangePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'date',
                                    'startAttribute' => 'start_date',
                                    'endAttribute' => 'end_date',
                                    'convertFormat' => true,
                                    'pluginOptions' => [
                                        'locale' => [
                                            'format' => 'Y-m-d',
                                            'separator' => ' to ',
                                        ]
                                    ]
                                ])
                            ],
                            'start_time',
                            'end_time',
                            [
                                'attribute' => 'bootcamp_id',
                                'filter' => $bootcamp_list,
                                'value' => function ($model) {
                                    return $model->bootcamp->name;
                                },
                            ],
                            [
                                'attribute' => 'speakers',
                                'format' => 'html',
                                'filter' => $person_list,
                                'value' => function ($model) {
                                    return implode(',<br>', Person::find()->getByAgendaID($model->id));
                                },
                            ],
                            [
                                'attribute' => 'mentors',
                                'format' => 'html',
                                'filter' => $person_list,
                                'value' => function ($model) {
                                    return implode(',<br>', Person::find()->getMentorsByAgendaID($model->id));
                                },
                            ],
                            [
                                'attribute' => 'order',
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
