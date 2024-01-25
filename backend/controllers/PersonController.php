<?php

namespace backend\controllers;

use backend\models\Bootcamp;
use backend\models\Person;
use backend\models\PersonSearch;
use common\components\FileHelper;
use common\components\FileUploader;
use common\models\PersonBootcamp;
use common\models\PersonType;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class PersonController extends Controller
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
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'bootcamp_list' => Bootcamp::find()->getList(),
            'type_list' => PersonType::getList(),
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
        $model = new Person();
        $model_image = new FileUploader();
        $image = UploadedFile::getInstance($model_image, 'image');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($image) {
                    $model_image->image = $image;

                    if ($model_image->validate()) {
                        $image_name = sprintf('%s.%s', uniqid(), $model_image->image->extension);
                        $model_image->image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/person/%s", $image_name)));
                        $model->image = $image_name;
                    }
                }

                if ($model->save()) {
                    if ($model->bootcamps) {
                        foreach ($model->bootcamps as $bootcamp) {
                            $person_bootcamp = new PersonBootcamp();
                            $person_bootcamp->person_id = $model->id;
                            $person_bootcamp->bootcamp_id = (int)$bootcamp;
                            $person_bootcamp->save();
                        }
                    }

                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', 'Successfully created a new person.'),
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
            'type_list' => PersonType::getList(),
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
        $image = UploadedFile::getInstance($model_image, 'image');

        $model->bootcamps = array_keys(Person::find()->getBootcampListById($id));
        $old_image = $model->image;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($image) {
                    $model_image->image = $image;

                    if ($model_image->validate()) {
                        $image_name = sprintf('%s.%s', uniqid(), $model_image->image->extension);
                        if ($model_image->image->saveAs(Yii::getAlias(sprintf("@frontend/web/uploads/person/%s", $image_name)))) {
                            $model->image = $image_name;
                            FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/person/%s", $old_image)));
                        } else {
                            $model->image = $old_image;
                        }
                    }
                }

                if ($model->save()) {
                    if ($model->bootcamps) {
                        PersonBootcamp::deleteAll(['person_id' => $model->id]);

                        foreach ($model->bootcamps as $bootcamp) {
                            $person_bootcamp = new PersonBootcamp();
                            $person_bootcamp->person_id = $model->id;
                            $person_bootcamp->bootcamp_id = (int)$bootcamp;
                            $person_bootcamp->save();
                        }
                    }
                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', sprintf('Successfully update a %s', sprintf('%s %s', $model->fName, $model->lName))),
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
            'type_list' => PersonType::getList(),
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
                FileHelper::deleteFile(Yii::getAlias(sprintf("@frontend/web/uploads/person/%s", $model->image)));
                Yii::$app->getSession()->setFlash('success',
                    [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => Yii::t('app', sprintf('Successfully deleted %s', sprintf('%s %s', $model->fName, $model->lName))),
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
     * @return Person|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
