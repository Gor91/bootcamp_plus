<?php

namespace backend\controllers;

use backend\models\AgendaSearch;
use backend\models\Bootcamp;
use backend\models\Person;
use backend\models\PersonSearch;
use common\components\FileHelper;
use common\components\FileUploader;
use common\models\Agenda;
use common\models\AgendaMentor;
use common\models\AgendaSpeaker;
use common\models\PersonBootcamp;
use common\models\PersonType;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use function Couchbase\defaultDecoder;

class AgendaController extends Controller
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
        $searchModel = new AgendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'bootcamp_list' => Bootcamp::find()->getList(),
            'person_list' => Person::find()->getList(),
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
        $model = new Agenda();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            echo "<pre>";
//            print_r($model);
//            die;
            try {
                if ($model->save()) {
                    if ($model->speakers) {
                        foreach ($model->speakers as $speaker) {
                            $agenda_speaker = new AgendaSpeaker();
                            $agenda_speaker->agenda_id = $model->id;
                            $agenda_speaker->speaker_id = (int)$speaker;
                            $agenda_speaker->save();
                        }
                    }

                    if ($model->mentors) {
                        foreach ($model->mentors as $mentor) {
                            $agenda_mentor = new AgendaMentor();
                            $agenda_mentor->agenda_id = $model->id;
                            $agenda_mentor->mentor_id = (int)$mentor;
                            $agenda_mentor->save();
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
            'person_list' => Person::find()->getList(),
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

        $model->speakers = array_keys(Person::find()->getByAgendaID($id));
        $model->mentors = array_keys(Person::find()->getMentorsByAgendaID($id));

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                if ($model->save()) {
                    if ($model->speakers) {
                        AgendaSpeaker::deleteAll(['agenda_id' => $model->id]);

                        foreach ($model->speakers as $speaker) {
                            $agenda_speaker = new AgendaSpeaker();
                            $agenda_speaker->agenda_id = $model->id;
                            $agenda_speaker->speaker_id = (int)$speaker;
                            $agenda_speaker->save();
                        }
                    } else {
                        AgendaSpeaker::deleteAll(['agenda_id' => $model->id]);
                    }

                    if ($model->mentors) {
                        AgendaMentor::deleteAll(['agenda_id' => $model->id]);

                        foreach ($model->mentors as $mentor) {
                            $agenda_mentor = new AgendaMentor();
                            $agenda_mentor->agenda_id = $model->id;
                            $agenda_mentor->mentor_id = (int)$mentor;
                            $agenda_mentor->save();
                        }
                    } else {
                        AgendaMentor::deleteAll(['agenda_id' => $model->id]);
                    }

                    Yii::$app->getSession()->setFlash('success',
                        [
                            'type' => 'success',
                            'duration' => 5000,
                            'icon' => 'fa fa-success',
                            'message' => Yii::t('app', sprintf('Successfully update a %s', $model->title)),
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
            'person_list' => Person::find()->getList(),
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
                Yii::$app->getSession()->setFlash('success',
                    [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => Yii::t('app', sprintf('Successfully deleted %s', $model->title)),
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
     * @return Agenda|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Agenda::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
