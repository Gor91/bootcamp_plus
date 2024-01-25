<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css'
    ];
    public $js = [
        'lib/jquery-3.5.1.min.js',
        'lib/popper.min.js',
        'lib/bootstrap/js/bootstrap.min.js',
        'lib/OwlCarousel/owl.carousel.min.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
