<?php

namespace backend\controllers;

use backend\models\Bootcamp;
use backend\models\Logo;
use common\components\FileHelper;
use common\components\FileUploader;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class LogoController extends Controller
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
     * Lists all Learning models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Logo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('index', [
            'bootcamp_list' => Bootcamp::find()->getList(),
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
        $model = new Logo();
        $model_image = new FileUploader();

        $model_image->setScenario(FileUploader::BOOTCAMP_LOGO);

        $image = UploadedFile::getInstance($model_image, 'logo');
        $model_image->logo = $image;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model_image->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $image_name = sprintf('%s.%s', uniqid(), $model_image->logo->extension);
                $model_image->logo->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/logo/%s", $image_name)));
                $model->logo = $image_name;

                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', 'Successfully created a new logo.'),
                            'positonY' => 'top',
                            'positonX' => 'center'
                        ]
                    );
                    $transaction->commit();

                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
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

        return $this->render('create', ['model' => $model,
            'bootcamp_list' => Bootcamp::find()->getList(),
            'model_image' => $model_image
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
                FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/logo/%s", $model->logo)));
                Yii::$app->getSession()->setFlash('success',
                    [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => Yii::t('app', 'Successfully deleted logo'),
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
     * @return Logo|null
     * @throws NotFoundHttpException
     */
    protected
    function findModel($id)
    {
        if (($model = Logo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
