<?php

namespace frontend\controllers;

use common\models\Agenda;
use common\models\Bootcamp;
use common\models\Gallery;
use common\models\LearningCategory;
use common\models\Logo;
use common\models\Person;
use common\models\PersonType;
use common\models\Profile;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $bootcamps = Bootcamp::find()->getActive();

        $nextOrCurrentBootcamp = Bootcamp::find()->getNextOrCurrent();

        return $this->render('index', ['bootcamps' => $bootcamps, 'isMore' => count($bootcamps) > 12, 'nextOrCurrentBootcamp' => $nextOrCurrentBootcamp]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBootcamp($slug)
    {
        $this->layout = 'bootcamp';

        $bootcamp = Bootcamp::find()->getBySlug($slug);

        if (!$bootcamp) {
            throw new NotFoundHttpException();
        }
        $bootcamp_id = $bootcamp['id'];

        $agenda = Agenda::find()->getByBootcampID($bootcamp_id);
        $mentors = Person::find()->getByBootcampID($bootcamp_id, PersonType::MENTOR);
        $speakers = Person::find()->getByBootcampID($bootcamp_id, PersonType::SPEAKER);
        $profiles = Profile::find()->getByBootcampID($bootcamp_id);
        $logos = Logo::find()->getByBootcampID($bootcamp_id);
        $gallery = Gallery::find()->getByBootcampID($bootcamp_id);
        $learningCategories = LearningCategory::find()->getByBootcampID($bootcamp_id);

        $this->view->params['is_agenda'] = !empty($agenda);
        $this->view->params['is_mentors_or_speakers'] = !empty($mentors) || !empty($speakers);
        $this->view->params['is_learning'] = !empty($learningCategories);
        $this->view->params['is_participants'] = !empty($profiles);
        $this->view->params['օrganizer_image'] = $bootcamp['organizer_image'];
        $this->view->params['bootcamp_name'] = $bootcamp['name'];
        $this->view->params['bootcamp_slug'] = $bootcamp['slug'];
        $this->view->params['logos'] = $logos;

        return $this->render('bootcamp', [
            'bootcamp' => $bootcamp,
            'agenda' => $agenda,
            'mentors' => $mentors,
            'speakers' => $speakers,
            'profiles' => $profiles,
            'gallery' => $gallery,
            'learningCategories' => $learningCategories
        ]);
    }

    /**
     * @return \yii\console\Response|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDownload()
    {
        $urlParts = parse_url(Yii::$app->request->referrer);

        if (!empty($urlParts['path'])) {
            $slug = trim($urlParts['path'], '/');
            $bootcamp = Bootcamp::findOne(compact('slug'));

            if (!empty($bootcamp) && $bootcamp->document) {
                $path = Yii::getAlias('@frontend') . '/web/uploads/bootcamp/document/' . $bootcamp->document;

                if (file_exists($path)) {
                    return Yii::$app->response->sendFile($path, sprintf('%s.pdf', $bootcamp->name));
                }
            }
        }

        throw new NotFoundHttpException();
    }
}
