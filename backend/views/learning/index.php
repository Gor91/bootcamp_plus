<?php

use common\widgets\Alert;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LearningSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Program List</h3>
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
                            'link',
                            [
                                'attribute' => 'category_id',
                                'filter' => $category_list,
                                'value' => function ($model) {
                                    return $model->category->name;
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
