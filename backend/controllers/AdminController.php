<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\ChangePassword;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Yii;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
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
                        'actions' => ['login'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['logout', 'error', 'index', 'profile', 'change-password', 'settings'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@', '?']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        $this->layout = 'main';
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/dashboard']);
        }

        $model = new Admin();
        $model->setScenario(Admin::SCENARIO_LOGIN);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /**@var $admin Admin */
            $admin = Admin::findByEmail($model->email);

            if (!is_null($admin) && (Yii::$app->getSecurity()->validatePassword(md5($model->password), $admin->password))) {
                try {
                    if (Yii::$app->user->login($admin)) {
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success',
                            'duration' => 3000,
                            'icon' => 'fa fa-info',
                            'message' => Yii::t('app', 'Welcome to dashboard!'),
                            'positonY' => 'top',
                            'positonX' => 'center'
                        ]);

                        return $this->redirect(['/dashboard']);
                    }
                } catch (\Exception $e) {
                    Yii::error($e->getMessage(), 'app');
                }
            }

            Yii::$app->getSession()->setFlash('warning', [
                'type' => 'warning',
                'duration' => 3000,
                'icon' => 'fa fa-info',
                'message' => Yii::t('app', 'Invalid login or password'),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws InternalErrorException
     */
    public function actionProfile()
    {
        $this->layout = 'main';

        /* @var $model Admin */
        $model = Admin::findOne(Yii::$app->user->identity->getId());
        $model->setScenario(Admin::SCENARIO_UPDATE);

        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', ['type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-success',
                    'message' => Yii::t('app', 'Profile updated success'),
                    'positonY' => 'top',
                    'positonX' => 'center'
                ]);
                return $this->redirect(['profile']);
            }
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), 'app');
            Yii::$app->getSession()->setFlash('error', ['type' => 'error',
                'duration' => 3000,
                'icon' => 'fa fa-danger',
                'message' => Yii::t('app', 'Profile don\'t updated'),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
        }

        if ($model->hasErrors()) {
            throw new InternalErrorException();
        }

        return $this->render('profile', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws InternalErrorException
     * @throws \yii\base\Exception
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /* @var $admin Admin */
            $admin = Admin::findOne(Yii::$app->user->id);;
            $admin->setPassword($model->password);

            try {
                if ($admin->save(false)) {
                    Yii::$app->getSession()->setFlash('success', ['type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => Yii::t('app', 'Password changed success'),
                        'positonY' => 'top',
                        'positonX' => 'center'
                    ]);
                    return $this->redirect(['change-password']);
                }
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), 'app');
                Yii::$app->getSession()->setFlash('error', ['type' => 'error',
                    'duration' => 3000,
                    'icon' => 'fa fa-danger',
                    'message' => Yii::t('app', 'An error has occurred'),
                    'positonY' => 'top',
                    'positonX' => 'center'
                ]);
            }
        }

        if ($model->hasErrors()) {
            throw new InternalErrorException();
        }

        return $this->render('change-password', [
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionError()
    {
        if (!Yii::$app->user->isGuest) {
            $this->layout = 'main';
        }

        return $this->render('error');
    }

    /**
     * @return string
     */
    public function actionSettings()
    {
        $file = sprintf('%s/config/params-local.php', Yii::getAlias('@common'));
        $conf = require $file;

        $keys = [
            'frontendUrl', 'email', 'phone',
            'reCaptchaSiteKey', 'reCaptchaSecret'
        ];

        $model = new DynamicModel($keys);

        $model->addRule($keys, 'filter', ['filter' => 'trim', 'skipOnArray' => true]);
        $model->addRule(['frontendUrl', 'reCaptchaSiteKey', 'reCaptchaSecret'], 'required');
        $model->addRule(['frontendUrl'], 'url');
        $model->addRule(['email'], 'email');
        $model->addRule(['phone', 'reCaptchaSiteKey', 'reCaptchaSecret'], 'string');


        $model->frontendUrl = $conf['frontendUrl'];
        $model->email = $conf['email'];
        $model->phone = $conf['phone'];
        $model->reCaptchaSiteKey = $conf['reCaptchaSiteKey'];
        $model->reCaptchaSecret = $conf['reCaptchaSecret'];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $conf['frontendUrl'] = $model->frontendUrl;
            $conf['email'] = $model->email;
            $conf['phone'] = $model->phone;
            $conf['reCaptchaSiteKey'] = $model->reCaptchaSiteKey;
            $conf['reCaptchaSecret'] = $model->reCaptchaSecret;

            file_put_contents($file, sprintf('<?php return %s %s %s;', PHP_EOL, PHP_EOL, var_export($conf, true)));
            Yii::$app->getSession()->setFlash('success', ['type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-success',
                'message' => Yii::t('app', 'Settings data are saved!'),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
        }

        return $this->render('settings', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $admin = Admin::findOne(Yii::$app->user->identity->getId());

        if (!is_null($admin)) {
            Yii::$app->user->logout(true);
        }

        return $this->goHome();
    }
}