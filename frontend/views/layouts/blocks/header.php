<?php

use yii\widgets\Menu;

?>
<section class="header-top-bar">
    <div class="container">
        <div class="row">
            <div class="">
                <ul class="contact-info list-group list-group-horizontal list-unstyled">
                    <li class="contact-info-phone me-4">
                        <i class="fa fa-phone me-2 fa-flip-horizontal"></i>
                        <a href="tel::+7 903 758 4747" class="text-decoration-none">+7 903 758 4747</a>
                    </li>
                    <li class="contact-info-email">
                        <i class="fa fa-envelope me-2"></i>
                        <a href="mailto:sokol.61@mail.ru" class="text-decoration-none">sokol.61@mail.ru</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<header class="header fixed-top">
    <nav class="navbar navbar-expand-md">
        <div class="container-md align-items-start">
            <a href="/">
                <img class="header__navbar_logo" src="/img/logo2.webp" alt="Соколиное Гнездо">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
                    aria-controls="offcanvasMenu" aria-expanded="false" aria-label="Меню" tabindex="-1">
                <i class="fa fa-bars"></i>
            </button>
            <div class="offcanvas align-items-end offcanvas-end header__navbar_menu mt-2 navbar-collapse"
                 id="offcanvasMenu">
                <button type="button" class="offcanvas-header btn-close " data-bs-dismiss="offcanvas"
                        aria-label="Закрыть"></button>
                <?= Menu::widget([
                    'activateItems' => true,
                    'activateParents' => true,
                    'encodeLabels' => false,
                    'items' => [
                        ['label' => 'Главная', 'url' => ['/'], 'active' => Yii::$app->requestedRoute === 'home/index'],
                        ['label' => 'Акции', 'url' => ['/news'], 'active' => Yii::$app->controller->actionParams['id'] === 'news'],
                        ['label' => 'Номера И Апартамены', 'url' => ['/room'], 'active' => Yii::$app->controller->actionParams['id'] === 'room'],
                        ['label' => 'Цены', 'url' => ['/prices'], 'active' => Yii::$app->controller->actionParams['id'] === 'prices'],
                        ['label' => 'Галерея', 'url' => ['/gallery'], 'active' => Yii::$app->requestedRoute === 'site/gallery'],
                        ['label' => 'Контакты', 'url' => ['/contact'], 'active' => Yii::$app->controller->actionParams['id'] === 'contact'],
                        // ['label' => 'Главная', 'url' => ['/']],
                        // ['label' => 'Акции', 'url' => ['/news']],
                        // ['label' => 'Номера И Апартамены', 'url' => ['/room']],
                        // ['label' => 'Цены', 'url' => ['/prices']],
                        // ['label' => 'Галерея', 'url' => ['/gallery']],
                        // ['label' => 'Контакты', 'url' => ['/contact']],
                    ],
                    'options' => [
                        'class' => 'offcanvas-body navbar-nav header__navbar_li',
                        'data' => 'menu',
                    ],
                    'itemOptions' => [
                        'class' => 'nav-item',
                    ],
                    'linkTemplate' => '<a class="nav-link " href="{url}">{label}</a>',
                    'activeCssClass' => 'active',
                ]);
                ?>
            </div>
        </div>
    </nav>
</header>