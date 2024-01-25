<?php
namespace common\widgets;

use kartik\growl\Growl;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Alert extends \yii\bootstrap\Alert
{
    /* @var $types array */
    public static $types = [
        'error' => 'alert alert-danger',
        'danger' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'info' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ];

    /**
     * Builder function
     */
    public static function builder()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $messages) {
            if (ArrayHelper::keyExists($type, self::$types)) {
                $message = (array)$messages;
                Growl::widget([
                    'type' => (!empty($message['type'])) ? $message['type'] : 'alert alert-danger',
                    'title' => (!empty($message['title'])) ? Html::encode($message['title']) : false,
                    'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                    'body' => (!empty($message['message'])) ? Html::encode($message['message']) : false,
                    'delay' => 0.2, //This delay is how long before the message shows
                    'pluginOptions' => [
                        'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                        'placement' => [
                            'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                            'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                        ]
                    ]
                ]);

                $session->removeFlash($type);
            }
        }
    }
}
