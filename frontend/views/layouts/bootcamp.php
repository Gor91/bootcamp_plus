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
    <?= $this->render('/partials/header') ?>
    <!--    end header-->

    <!--    start contact-->
    <?= $content ?>
    <!--    end contact-->

    <!--  start footer  -->
    <?= $this->render('/partials/footer') ?>
    <!--  end footer  -->

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
