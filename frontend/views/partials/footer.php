<?php

use yii\helpers\Url;

?>
<section id="contact" class="contact">
    <div class="container">
        <h2 class="contact__title title">Contact us</h2>
        <div class="row">
            <div class="contact__info col-md-3 col-sm-12">
                <h3 class="contact__info__title">email</h3>
                <a href="mailto:<?= $email = Yii::$app->params['email'] ?>"
                   class="contact__info__link"><?= $email ?></a>
            </div>
            <div class="contact__info col-md-3 col-sm-12">
                <h3 class="contact__info__title">phone</h3>
                <a href="tel:<?= $tel = Yii::$app->params['phone'] ?>"
                   class="contact__info__link"><?= $tel ?></a>
            </div>
        </div>
        <div class="row organize">
            <div class="col-md-4 col-sm-12 organize__item">
                <h3 class="organize__item__title">ORGANIZED BY</h3>
                <figure class="organize__item__figure">
                    <a href="#" class="organize__item__link">
                        <img src="<?= !empty($this->params['օrganizer_image']) ? Url::to([sprintf("uploads/bootcamp/organizer/%s", $this->params['օrganizer_image'])]) : 'img/logo/logo-eif.png' ?>"
                             alt="" class="organize__item__img" width="217" height="65">
                    </a>
                </figure>
            </div>
            <div class="col-md-8 col-sm-12 organize__item">
                <h3 class="organize__item__title">IN PARTNERSHIP WITH</h3>
                <figure class="organize__item__figure">
                    <?php if (!empty($this->params['logos'])):
                        foreach ($this->params['logos'] as $logo):?>
                            <a href="<?= $logo->link ?: '#' ?>" class="organize__item__link" target="_blank">
                                <img src="<?= Url::to([sprintf("uploads/logo/%s", $logo->logo)]) ?>" alt=""
                                     class="organize__item__img" width="175" height="175">
                            </a>
                        <?php endforeach; else: ?>
                            <a href="#" class="organize__item__link">
                                <img src="img/logo/logo-hti.png" alt="" class="organize__item__img" width="200"
                                     height="175">
                            </a>
                            <a href="#" class="organize__item__link">
                                <img src="img/logo/logo-ra-gov.png" alt="" class="organize__item__img" width="175"
                                     height="175">
                            </a>
                            <a href="#" class="organize__item__link">
                                <img src="img/logo/logo-wb.png" alt="" class="organize__item__img" width="314" height="65">
                            </a>
                    <?php endif; ?>
                </figure>
            </div>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="container">
        <div class="footer__copyright">&copy; EIF | All rights Reserved <?= date('Y') ?></div>
    </div>
</footer>