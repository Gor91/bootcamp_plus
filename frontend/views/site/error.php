<?php

/* @var $this yii\web\View */

$this->title = 'Page not found';
?>

<section id="erorr" class="agenda">
    <div class="container">
        <h2 class="agenda__title title">⚠ 404 page not found :(</h2>
        <br />
        <h2 class="agenda__title text-center title">go to -> <a href="/">home</a></h2>
    </div>
</section>
<?php $this->registerJs("
 $(window).on('load',function (event) {
        $('html,body').animate({
            scrollTop: $('#erorr').offset().top
        }, 1000, 'swing');
    });
")?>