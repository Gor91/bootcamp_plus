<?php

namespace backend\controllers;

use backend\models\Bootcamp;
use backend\models\ProfileSearch;
use common\components\FileHelper;
use common\components\FileUploader;
use common\models\Profile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProfileController extends Controller
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
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'bootcamp_list' => Bootcamp::find()->getList(),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model_image = new FileUploader();

        $image = UploadedFile::getInstance($model_image, 'info_url');
        $model_image->info_url = $image;

        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if(!empty($model_image->info_url)){
                    $image_name = sprintf('%s.%s', uniqid(), $model_image->info_url->extension);
                    $model_image->info_url->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/profile/%s", $image_name)));
                    $model->info_url = $image_name;
                }

                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', 'Successfully created a new profile.'),
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
            'model_image' => $model_image,
            'bootcamp_list' => Bootcamp::find()->getList()
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

        $image = UploadedFile::getInstance($model_image, 'info_url');

        $current_info = $model->info_url;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $model_image->info_url = $image;

                if(!empty($model_image->info_url)){
                    $image_name = sprintf('%s.%s', uniqid(), $model_image->info_url->extension);
                    $model_image->info_url->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/profile/%s", $image_name)));
                    FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/profile/%s", $current_info)));
                    $model->info_url = $image_name;
                }

                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', sprintf('Successfully update a %s', $model->company_name)),
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
            'model_image' => $model_image,
            'model_old_info_url' => $current_info,
            'bootcamp_list' => Bootcamp::find()->getList()
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
                if(!empty($model->info_url)){
                    FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/profile/%s", $model->info_url)));
                }
                Yii::$app->getSession()->setFlash('success',
                    [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => Yii::t('app', sprintf('Successfully deleted %s', $model->company_name)),
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
     * @param $id
     * @return Profile|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
