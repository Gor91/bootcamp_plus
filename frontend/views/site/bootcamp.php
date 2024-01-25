<?php

use yii\helpers\Url;

?>
<!--    start banner-->
<section id="banner" class="banner"
         style="background-image: url(<?= $bootcamp["header_image"] ? Url::to([sprintf('/uploads/bootcamp/header/%s', $bootcamp["header_image"])]) : 'img/banner/bg.png' ?>);">
    <div class="container">
        <figure class="banner__logo">
            <a href="/" class="banner__logo__link" width="150" height="50">
                <img src="img/logo/logo-eif.png" alt="" class="banner__logo__img" width="150" height="50">
            </a>
        </figure>
        <div class="row justify-content-between banner__content ">
            <div class="col-9">
                <div class="banner__desc">
                    <h3 class="banner__sub__title">
                        EIF Bootcamp, Mentorship & Acceleration Platform
                    </h3>
                    <h1 class="banner__title">
                        <?= $bootcamp["name"] ?>
                    </h1>
                    <a href="#"
                       class="banner__apply"><?= $bootcamp->dateRanges($bootcamp["start_date"], $bootcamp["end_date"]) ?></a>
                </div>
            </div>
            <div class="col-3">
                <nav class="banner__nav ">
                    <ul class="banner__nav__block">
                        <li class="banner__nav__list"><a href="#about" class="banner__nav__link">Methodology</a></li>
                        <?php if ((!empty($this->params['is_agenda']))) : ?>
                            <li class="banner__nav__list"><a href="#agenda" class="banner__nav__link">Agenda</a></li>
                        <?php endif; ?>
                        <?php if (!empty($this->params['is_mentors_or_speakers'])) : ?>
                            <li class="banner__nav__list"><a href="#mentors" class="banner__nav__link">Mentors</a></li>
                        <?php endif; ?>
                        <?php if ((!empty($this->params['is_participants']))) : ?>
                            <li class="banner__nav__list">
                                <a href="#participants" class="banner__nav__link">Participants</a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($this->params['is_learning'])): ?>
                            <li class="banner__nav__list"><a href="#learning" class="banner__nav__link">Program</a></li>
                        <?php endif; ?>
                        <li class="banner__nav__list"><a href="#contact" class="banner__nav__link">Contacts</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>

</section>
<!--    end banner-->
<!--    start about-->
<section id="about" class="about">
    <div class="container">
        <div class="container">
            <div class="row align-items-center justify-content-between flex-md-row flex-sm-column justify-content-sm-center">
                <div class="col-md-6 col-sm-12 justify-content-sm-center">
                    <figure class="about__figure">
                        <img src="<?= $bootcamp["image"] ? Url::to([sprintf('/uploads/bootcamp/%s', $bootcamp["image"])]) : '/img/post/about.png' ?>"
                             alt="" class="about__img">
                    </figure>
                </div>
                <div class="col-md-6 col-sm-12 p-sm-1">
                    <h2 class="about__title title">Methodology</h2>
                    <p class="about__desc">
                        <?= $bootcamp["about"] ?>
                        <?php if ($bootcamp["document"]): ?>
                            <a href="<?= Url::to(['download/document']) ?>"> more info</a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--    end about-->

<!--    start agenda-->
<?php if (!empty($agenda)) : ?>
    <section id="agenda" class="agenda">
        <div class="container">
            <h2 class="agenda__title title">Agenda</h2>
        </div>
        <div class="agenda__cont owl-carousel agenda__item__big">
            <?php $day = 0;
            $session = 1;
            $old_date = '' ?>

            <?php foreach ($agenda as $item) :
                $date = $item['date'];

                if ($old_date == $date) {
                    $session++;
                } else {
                    $old_date = $item['date'];
                    $session = 1;

                    $day++;
                }
                ?>
                <div class="item agenda__item">
                    <?php if (!empty($item["video_url"])) { ?>
                        <a href="<?= $item["video_url"] ?>" target="_blank"><p
                                    class="agenda__day__big"><?= sprintf('day %d session %s', $day, $session); ?></p>
                        </a>
                    <?php } else { ?>
                        <p class="agenda__day__big"><?= sprintf('day %d session %s', $day, $session); ?></p>
                    <?php } ?>
                    <p class="agenda__day__small"><?= date_format(date_create($item['date']), 'F d, Y') ?></p>
                    <p class="agenda__day__small"><?= sprintf('%s-%s', $item['start_time'], $item['end_time']) ?></p>
                    <?= $item['content'] ?>
                    <?php if (!empty($item['agendaSpeakers'])): ?>
                        <h5 class="agenda__speakers__title">Speakers</h5>
                        <?php foreach ($item['agendaSpeakers'] as $speaker) : ?>
                            <div class="agenda__speakers__row">
                                <img src="<?= Url::to([sprintf("uploads/person/%s", $speaker['image'])]) ?>"
                                     alt="<?= sprintf("%s %s", $speaker['fName'], $speaker['lName']) ?>"
                                     class="agenda__speakers__avatar__list">
                                <p class="agenda__speakers__name"><?= sprintf("%s %s", $speaker['fName'], $speaker['lName']) ?></p>
                            </div>
                        <?php endforeach;
                    endif; ?>

                    <?php if (!empty($item['agendaMentors'])): ?>
                        <h5 class="agenda__speakers__title">Mentors</h5>
                        <?php foreach ($item['agendaMentors'] as $mentor) : ?>
                            <div class="agenda__speakers__row">
                                <img src="<?= Url::to([sprintf("uploads/person/%s", $mentor['image'])]) ?>"
                                     alt="<?= sprintf("%s %s", $mentor['fName'], $mentor['lName']) ?>"
                                     class="agenda__speakers__avatar__list">
                                <p class="agenda__speakers__name"><?= sprintf("%s %s", $mentor['fName'], $mentor['lName']) ?></p>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
<!--    end agenda-->
<!--    start mentors__speakers-->
<?php if (!empty($mentors) || !empty($speakers)) : ?>
    <section id="mentors" class="mentors__speakers">
        <div class="container">
            <h2 class="mentors__speakers__title title">
                Mentors/Speakers
            </h2>
            <?php if (!empty($speakers)): ?>
                <div class="speakers__block">
                    <h3 class="speakers__title">Speakers <img src="img/icons/iocn-speakers.png" alt=""
                                                              class="speakers__title__icon"></h3>
                    <div class="row">
                        <?php foreach ($speakers as $speaker) : ?>
                            <div class="speakers col-md-3 col-sm-12">
                                <img src="<?= Url::to([sprintf("uploads/person/%s", $speaker['image'])]) ?>"
                                     alt="<?= sprintf("%s %s", $speaker['fName'], $speaker['lName']) ?>"
                                     class="speakers__img">
                                <a href="<?= $speaker->link ?: "#" ?>" target="_blank">
                                    <h4 class="speakers__name"><?= sprintf("%s %s", $speaker['fName'], $speaker['lName']) ?></h4>
                                </a>
                                <p class="speakers__position"><?= $speaker['position'] ?></p>
                                <p class="speakers__company"><?= $speaker['company'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;
            if (!empty($mentors)): ?>
                <div class="speakers__block">
                    <h3 class="speakers__title">Mentors <img src="img/icons/icon-mentors.png" alt=""
                                                             class="speakers__title__icon"></h3>
                    <div class="row">
                        <?php foreach ($mentors as $mentor) : ?>
                            <div class="speakers col-md-3 col-sm-12">
                                <img src="<?= Url::to([sprintf("uploads/person/%s", $mentor['image'])]) ?>"
                                     alt="<?= sprintf("%s %s", $mentor['fName'], $mentor['lName']) ?>"
                                     class="speakers__img">
                                <a href="<?= $mentor->link ?: "#" ?>" target="_blank">
                                    <h4 class="speakers__name"><?= sprintf("%s %s", $mentor['fName'], $mentor['lName']) ?></h4>
                                </a>
                                <p class="speakers__position"><?= $mentor['position'] ?></p>
                                <p class="speakers__company"><?= $mentor['company'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<!--    start gallery-->
<?php if (!empty($gallery)) : ?>
    <section id="agendas" class="agenda">
        <div class="container">
            <h2 class="mentors__speakers__title title">
                Gallery
            </h2>
        </div>
        <div class="agenda__cont owl-carousel agenda__cont_slider">
            <?php foreach ($gallery as $image) : ?>
                <div class="item gallery__item">
                    <img src="<?= Url::to([sprintf("uploads/gallery/%s", $image['image'])]) ?>" alt=""
                         class="gallery__item__img">
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
<!--    and gallery-->

<!--    end mentors__speakers-->
<!--start participants-->
<?php if (!empty($profiles)) : ?>
    <section id="participants" class="participants">
        <div class="container">
            <h2 class="participants__title title">Participants</h2>
            <div class="row justify-content-center">
                <div class="col-11">
                    <div class="row justify-content-between">
                        <?php foreach ($profiles as $profile) : ?>
                            <div class="col-md-4 col-sm-12">
                                <?php if (empty($profile->info_url)) { ?>
                                    <h5 class="participants__name"><?= $profile['company_name'] ?></h5>
                                <?php } else { ?>
                                    <a href="<?= Url::to([sprintf("uploads/profile/%s", $profile->info_url)]) ?>"
                                       download>
                                        <h5 class="participants__name"><?= $profile['company_name'] ?></h5>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php endif; ?>
<!--    end participants-->
<!--start Learning-->
<?php if (!empty($learningCategories)) : ?>
    <section id="learning" class="learning">
        <div class="container">
            <h2 class="learning__title title">Program</h2>
            <ul class="nav nav-pills learning__nav" id="pills-tab" role="tablist">
                <?php $i = 0;
                foreach ($learningCategories as $learningCategorie) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $i == 0 ? 'active' : '' ?>"
                           id="<?= "a" . $learningCategorie['id'] ?>-tab"
                           data-toggle="pill"
                           href="#<?= "a" . $learningCategorie['id'] ?>__cont"
                           role="tab"
                           aria-controls="<?= "a" . $learningCategorie['id'] ?>__cont"
                           aria-selected="true"><?= $learningCategorie['name'] ?></a>
                    </li>
                    <?php $i++; endforeach; ?>

            </ul>
            <div class="tab-content learning__content" id="pills-tabContent">
                <?php $j = 0;
                foreach ($learningCategories

                as $learningCategorie) :
                if ($j == 0){ ?>
                <div class="tab-pane fade show active"
                     id="<?= "a" . $learningCategorie['id'] ?>__cont"
                     role="tabpanel"
                     aria-labelledby="<?= "a" . $learningCategorie['id'] ?>-tab">
                    <div class="row">
                        <?php $j++;
                        }else{ ?>
                        <div class="tab-pane fade"
                             id="<?= "a" . $learningCategorie['id'] ?>__cont"
                             role="tabpanel"
                             aria-labelledby="<?= "a" . $learningCategorie['id'] ?>-tab">
                            <div class="row">

                                <?php } ?>
                                <?php foreach ($learningCategorie['learnings'] as $learn) : ?>
                                    <div class="learning__item col-md-4 col-sm-12">
                                        <img src="<?= Url::to([sprintf('uploads/learning/%s', $learn['image'])]) ?>"
                                             alt="<?= $learn['name'] ?>" class="learning__item__img">
                                        <a target="_blank" href="<?= $learn['link'] ?>">
                                            <h5 class="learning__item__title"><?= $learn['name'] ?></h5>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

    </section>
<?php endif; ?>

<!--end Learning-->