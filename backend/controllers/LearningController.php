<?php

namespace backend\controllers;

use backend\models\LearningSearch;
use common\components\FileHelper;
use common\components\FileUploader;
use common\models\LearningCategory;
use Yii;
use common\models\Learning;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * LearningController implements the CRUD actions for Learning model.
 */
class LearningController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Learning models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LearningSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'category_list' => LearningCategory::find()->getList(),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Learning model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Learning();
        $model_image = new FileUploader();
        $image = UploadedFile::getInstance($model_image, 'image');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($image) {
                    $model_image->image = $image;

                    if ($model_image->validate()) {
                        $image_name = sprintf('%s.%s', uniqid(), $model_image->image->extension);
                        $model_image->image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/learning/%s", $image_name)));
                        $model->image = $image_name;
                    }
                }

                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', 'Successfully created a new learning.'),
                            'positonY' => 'top',
                            'positonX' => 'center'
                        ]
                    );

                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), 'app');
                Yii::$app->getSession()->setFlash('error', [
                    'type' => 'error',
                    'duration' => 3000,
                    'icon' => 'fa fa-info',
                    'message' => Yii::t('app', $e->getMessage()),
                    'positonY' => 'top',
                    'positonX' => 'center'
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'image' => $model_image,
            'category_list' => LearningCategory::find()->getList()
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_image = new FileUploader();
        $image = UploadedFile::getInstance($model_image, 'image');

        $old_image = $model->image;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($image) {
                    $model_image->image = $image;

                    if ($model_image->validate()) {
                        $image_name = sprintf('%s.%s', uniqid(), $model_image->image->extension);
                        if ($model_image->image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/learning/%s", $image_name)))) {
                            $model->image = $image_name;
                            FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/learning/%s", $old_image)));
                        } else {
                            $model->image = $old_image;
                        }
                    }
                }

                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', sprintf('Successfully update a %s', $model->name)),
                            'positonY' => 'top',
                            'positonX' => 'center'
                        ]
                    );
                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), 'app');
                Yii::$app->getSession()->setFlash('error', [
                    'type' => 'error',
                    'duration' => 3000,
                    'icon' => 'fa fa-info',
                    'message' => Yii::t('app', $e->getMessage()),
                    'positonY' => 'top',
                    'positonX' => 'center'
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'image' => $model_image,
            'category_list' => LearningCategory::find()->getList()
        ]);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try {
            if ($model->delete()) {
                FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/learning/%s", $model->image)));
                Yii::$app->getSession()->setFlash('success',
                    [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => Yii::t('app', sprintf('Successfully deleted %s', $model->name)),
                        'positonY' => 'top',
                        'positonX' => 'center'
                    ]
                );
            };
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), 'app');
            Yii::$app->getSession()->setFlash('error', [
                'type' => 'error',
                'duration' => 3000,
                'icon' => 'fa fa-info',
                'message' => Yii::t('app', $e->getMessage()),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Learning model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Learning the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Learning::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
