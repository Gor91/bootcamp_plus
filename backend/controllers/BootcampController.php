<?php

namespace backend\controllers;

use common\components\FileHelper;
use common\components\FileUploader;
use Yii;
use common\models\Bootcamp;
use backend\models\BootcampSearch;
use yii\caching\DbDependency;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use function Couchbase\defaultDecoder;

/**
 * BootcampController implements the CRUD actions for Bootcamp model.
 */
class BootcampController extends Controller
{
    /**
     * @return array
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
     * Lists all Bootcamp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BootcampSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Bootcamp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bootcamp();
        $model_image = new FileUploader();
        $model_header_image = new FileUploader();
        $model_document = new FileUploader();
        $model_organizer_image = new FileUploader();
        $image = UploadedFile::getInstance($model_image, 'image');
        $header_image = UploadedFile::getInstance($model_header_image, 'header_image');
        $document = UploadedFile::getInstance($model_document, 'document');
        $organizer_image = UploadedFile::getInstance($model_organizer_image, 'organizer_image');
//        echo "<pre>";
//        print_r($model);die;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($image) {
                    $model_image->image = $image;

                    if ($model_image->validate()) {
                        $image_name = sprintf('%s.%s', uniqid(), $model_image->image->extension);
                        $model_image->image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/%s", $image_name)));
                        $model->image = $image_name;
                    }
                }

                if ($header_image) {
                    $model_header_image->header_image = $header_image;

                    if ($model_header_image->validate()) {
                        $header_image_name = sprintf('%s.%s', uniqid(), $model_header_image->header_image->extension);
                        $model_header_image->header_image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/header/%s", $header_image_name)));
                        $model->header_image = $header_image_name;
                    }
                }

                if ($organizer_image) {
                    $model_organizer_image->organizer_image = $organizer_image;

                    if ($model_organizer_image->validate()) {
                        $organizer_image_name = sprintf('%s.%s', uniqid(), $model_organizer_image->organizer_image->extension);
                        $model_organizer_image->organizer_image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/organizer/%s", $organizer_image_name)));
                        $model->organizer_image = $organizer_image_name;
                    }
                }

                if ($document) {
                    $model_document->document = $document;

                    if ($model_document->validate()) {
                        $document_name = sprintf('%s.%s', uniqid(), $model_document->document->extension);
                        $model_document->document->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/document/%s", $document_name)));
                        $model->document = $document_name;
                    }
                }

                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', 'Successfully created a new bootcamp.'),
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
            'header_image' => $model_header_image,
            'document' => $model_document,
            'organizer_image' => $model_organizer_image
        ]);
    }

    /**
     * Updates an existing Bootcamp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_image = new FileUploader();
        $model_header_image = new FileUploader();
        $model_document = new FileUploader();
        $model_organizer_image = new FileUploader();
        $image = UploadedFile::getInstance($model_image, 'image');
        $header_image = UploadedFile::getInstance($model_header_image, 'header_image');
        $document = UploadedFile::getInstance($model_document, 'document');
        $organizer_image = UploadedFile::getInstance($model_organizer_image, 'organizer_image');

        $old_image = $model->image;
        $old_header_image = $model->header_image;
        $old_document = $model->document;
        $old_organizer_image = $model->organizer_image;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($image) {
                    $model_image->image = $image;

                    if ($model_image->validate()) {
                        $image_name = sprintf('%s.%s', uniqid(), $model_image->image->extension);
                        if ($model_image->image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/%s", $image_name)))) {
                            $model->image = $image_name;
                            FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/%s", $old_image)));
                        } else {
                            $model->image = $old_image;
                        }
                    }
                }

                if ($header_image) {
                    $model_header_image->header_image = $header_image;

                    if ($model_header_image->validate()) {
                        $header_image_name = sprintf('%s.%s', uniqid(), $model_header_image->header_image->extension);
                        if ($model_header_image->header_image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/header/%s", $header_image_name)))) {
                            $model->header_image = $header_image_name;
                            FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/header/%s", $old_header_image)));
                        } else {
                            $model->header_image = $old_header_image;
                        }
                    }
                }

                if ($document) {
                    $model_document->document = $document;

                    if ($model_document->validate()) {
                        $document_name = sprintf('%s.%s', uniqid(), $model_document->document->extension);
                        if ($model_document->document->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/document/%s", $document_name)))) {
                            $model->document = $document_name;
                            FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/document/%s", $old_document)));
                        } else {
                            $model->document = $old_document;
                        }
                    }
                }

                if ($organizer_image) {
                    $model_organizer_image->organizer_image = $organizer_image;

                    if ($model_organizer_image->validate()) {
                        $organizer_image_name = sprintf('%s.%s', uniqid(), $model_organizer_image->organizer_image->extension);
                        if ($model_organizer_image->organizer_image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/organizer/%s", $organizer_image_name)))) {
                            $model->organizer_image = $organizer_image_name;
                            FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/organizer/%s", $old_organizer_image)));
                        } else {
                            $model->organizer_image = $old_organizer_image;
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
            'header_image' => $model_header_image,
            'document' => $model_document,
            'organizer_image' => $model_organizer_image
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try {
            if ($model->delete()) {
                FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/%s", $model->image)));
                FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/header/%s", $model->header_image)));
                FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/document/%s", $model->document)));
                FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/bootcamp/document/%s", $model->organizer_image)));
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
     * Finds the Bootcamp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bootcamp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bootcamp::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
