<?php

/** @var \yii\web\View $this */

use frontend\assets\AppAssetMain;
use frontend\widgets\content\ContentWidget;
use frontend\widgets\photoLightBox\photoLightBox;
use frontend\widgets\PhotoSlider\PhotoSlider;
use yii\helpers\Html;

AppAssetMain::register($this);
$this->title = 'Соколиное гнездо';
$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
?>
<main class="main">
    <section class="main__content_body">
        <div class="container">
            <div class="main__content_hello row justify-content-start pt-100">
                <div class="main__content_slider col-lg-6">
                    <?= PhotoSlider::widget(['gallery' => '643668d0664f5', 'view' => 'home']) ?>
                </div>
                <div class="main__content_text col-lg-6">
                    <h3 class="main__content_title ms-lg-4 fs-sm-22">
                        Добро пожаловать!
                    </h3>
                    <div class="main__content_desc ms-lg-4">
                        <span class="fs-sm-14">Россия, Краснодарский Край, г. Геленджик,</span><br>
                        <span class="fs-sm-14">пос. Архипо-Осиповка, Пицундский проезд, 2</span><br>
                        <span class="fs-sm-14">Телефон:
                            <a href="tel::+79182887185" class="text-decoration-none">+7 (918) 288 71 85</a>,
                            <a href="tel::+79037584747" class="text-decoration-none">+7 (903) 758 47 47</a>
                        </span>
                        <br>
                        <span class="fs-sm-14">E-mail:
                            <a href="mailto:sokol.61@mail.ru" class="text-decoration-none">sokol.61@mail.ru</a>
                        </span>
                        <br>
                        <span class="fs-sm-14"> GPS: 44.361557 , 38.543541
                            <small>
                                <a href="https://goo.gl/maps/pYJznh5y1LunUHd69" class="text-decoration-none">Google карта</a>
                                <a href="https://yandex.ru/maps/-/C0gIzSi-"
                                   class="text-decoration-none">Яндекс Карта</a>
                            </small>
                        </span>
                    </div>
                    <div class="row ms-lg-2">
                        <?= photoLightBox::widget(['gallery' => '643668d0664f5', 'view' => 'home']) ?>
                    </div>
                </div>
            </div>
            <div class="main__content_about mt-5">
                <p>Гостевой дом «Соколиное гнездо» находится в посёлке Архипо-Осиповка, Города-курорта Геленджик,
                    Краснодарского края. Поселок располагается между двух рек – Вулан и Тешебс в окружении дубовых
                    рощ. Уникальный черноморский климат и развитая инфраструктура поселка располагает к активному
                    отдыху и способствует быстрому восстановлению жизненных сил.
                </p>
                <p>Гостевой дом 2012 года постройки, расположен у подножия горы "Ёжик".
                    Из-за густой зелени предгорья на территории комплекса всегда свежий, горный воздух. Даже в
                    сильный зной гора отдаёт прохладой. По утрам наслаждаешься пением соловьёв, днём наблюдаешь за
                    шумными играми соек, а поздним вечером можно увидеть сов и летучих мышей. Бывает и еноты заходят
                    в гости. Только здесь вы сможете отдохнуть от прибрежного шума и пляжной суеты в тихой,
                    комфортной и домашней обстановке. Из-за удалённости от пляжной зоны ( 800 м. - 15-20 минут
                    пешком ) нами организован бесплатный трансфер до моря и обратно на микроавтобусе.
                </p>
                <p class="text-center">
                    <img src="/img/heading-bg.webp" width="396" height="45">
                </p>
            </div>
            <?= ContentWidget::widget(['template' => 'index_about', 'cat_id' => 31]) ?>
            <?= ContentWidget::widget(['template' => 'index_about_text', 'cat_id' => 32]) ?>
        </div>
        <?= ContentWidget::widget(['template' => 'news', 'cat_id' => 33]) ?>
    </section>
</main>

