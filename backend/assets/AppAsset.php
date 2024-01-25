<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
        'css/lte.min.css',
        'css/site.css',
        'css/skins/_all-skins.min.css',
//        'css/lib/select2/select2.min.css'
    ];

    public $js = [
        'js/adminlte.min.js',
        'js/bootstrap-datepicker.js',
//        'js/select2.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
