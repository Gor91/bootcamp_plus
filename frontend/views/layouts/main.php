<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <!--    start header-->
    <header class="header">
        <div class="container">

        </div>
    </header>
    <!--    end header-->
    <!--    start banner-->
    <section id="banner" class="banner" style="background-image: url(img/banner/bg2.png);">
        <div class="container">
            <figure class="banner__logo">
                <a href="/" class="banner__logo__link"  width="150" height="50">
                    <img src="img/logo/logo-eif.png" alt="" class="banner__logo__img" width="150" height="50" >
                </a>
            </figure>
            <div class="row justify-content-between banner__content ">
                <div class="col-9">
                    <div class="banner__desc">
                        <h3 class="banner__sub__title">
                            EIF Bootcamp, Mentorship & Acceleration Platform
                        </h3>

<!--                        <a href="#" class="banner__apply" disabled="disabled"> APPLY</a>-->
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </section>
    <!--    end banner-->

    <?= $content ?>

    <!--    start contact-->
    <?= $this->render('/partials/footer')?>
    <!--    end contact-->


</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
