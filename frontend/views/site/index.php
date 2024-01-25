<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Bootcamp';
?>
<?php if ($nextOrCurrentBootcamp): ?>
    <!--    start about-->
    <section id="about" class="about ">
        <div class="container">
            <div class="container">
                <div class="row align-items-center justify-content-between flex-md-row flex-sm-column justify-content-sm-center">
                    <h2 class="agenda__title title mb40"><?= sprintf('%s Bootcamp', $nextOrCurrentBootcamp['period']) ?></h2>
                    <div class="col-md-6 col-sm-12 justify-content-sm-center">
                        <figure class="about__figure">
                            <img src="<?= $nextOrCurrentBootcamp['data']->image ? Url::to([sprintf('/uploads/bootcamp/%s', $nextOrCurrentBootcamp['data']->image)]) : 'img/post/about.png' ?>"
                                 alt="<?= $nextOrCurrentBootcamp['data']->name ?>" class="about__img">
                        </figure>
                    </div>
                    <div class="col-md-6 col-sm-12 p-sm-1">
                        <h2 class="about__title title fz32">
                            <?= $nextOrCurrentBootcamp['data']->name ?>
                        </h2>
                        <p class="agenda__day__small">Start
                            date <?= date_format(date_create($nextOrCurrentBootcamp['data']->start_date), 'M d, Y') ?></p>
                        <p class="agenda__day__small">End
                            date <?= date_format(date_create($nextOrCurrentBootcamp['data']->end_date), 'M d, Y') ?></p>
                        <p class="about__desc mt20">
                            <?= $nextOrCurrentBootcamp['data']->about ?>
                            <a href="<?= "/" . $nextOrCurrentBootcamp['data']->slug ?>">More</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end about-->
<?php endif; ?>
<section id="agenda" class="agenda">
    <div class="container">
        <h2 class="agenda__title title">Bootcamps</h2>
    </div>
    <div class="agenda__cont <?= $isMore ? 'agenda__cont__more' : '' ?>">
        <div class="agenda__item__main__wrapper">
            <p class="agenda__day__big"><a target="_blank" href="http://185.149.142.15/">INNOVATION MATCHING GRANT BOOTCAMP</a></p>

            <div class="item agenda__item__main__page">
                <p class="agenda__day__big"><a href="http://bootcamp.eif.am/" target="_blank">INNOVATION MATCHING GRANT
                        BOOTCAMP</a></p>
                <p class="agenda__day__small">Start
                    date Jun 03, 2020</p>
                <p class="agenda__day__small">End
                    date Jun 10, 2020</p>
                <div class="agenda__speakers__row">
                    <img src="img/post/about.png" alt="" class="agenda__speakers__avatar">
                </div>
                <p class="agenda__day__title"><b>About</b></p>
                <div class="agenda__day__small agenda__day__small__boot"><p><span
                                style="color: rgb(0, 0, 0); font-family: Lato, sans-serif; font-size: 16px; letter-spacing: 0.58px;">IMG Bootcamp is here to help ambitious startups and founders to grow. The bootcamp provides a unique opportunity to learn from prominent local and international entrepreneurs and industry experts through online workshops and 1 on 1 mentorship sessions. Throughout the program startups will work with mentors on their pitch &amp; presentation and prepare for showcasing it during the Venture Forum. The bootcamp will also help to gain insights about the startup development, such as product development, growth and funding attraction.</span>
                    </p></div>
            </div>
        </div>
        <?php if (!empty($bootcamps)): ?>
            <?php foreach ($bootcamps as $bootcamp): ?>
                <div class="agenda__item__main__wrapper">
                    <p class="agenda__day__big"><a href="<?= "/" . $bootcamp->slug ?>"><?= $bootcamp->name ?></a></p>

                    <div class="item agenda__item__main__page">
                        <p class="agenda__day__big"><a href="<?= "/" . $bootcamp->slug ?>"
                                                       target="_blank"><?= $bootcamp->name ?></a></p>
                        <p class="agenda__day__small">Start
                            date <?= date_format(date_create($bootcamp->start_date), 'M d, Y') ?></p>
                        <p class="agenda__day__small">End
                            date <?= date_format(date_create($bootcamp->end_date), 'M d, Y') ?></p>
                        <div class="agenda__speakers__row">
                            <img src="<?= $bootcamp->image ? Url::to([sprintf('/uploads/bootcamp/%s', $bootcamp->image)]) : 'img/post/about.png' ?>"
                                 alt="" class="agenda__speakers__avatar">
                        </div>
                        <p class="agenda__day__title"><b>About</b></p>
                        <div class="agenda__day__small agenda__day__small__boot"><?= $bootcamp->about ?></div>
                    </div>
                </div>
            <?php endforeach; endif ?>
    </div>
</section>