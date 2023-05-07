<?php

/** @var \yii\web\View $this */

/** @var string $content */

use frontend\assets\AppAssetMain;
use frontend\widgets\content\ContentWidget;
use frontend\widgets\forms\feedback\FeedbackWidget;
use yii\helpers\Html;

AppAssetMain::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('blocks/head'); ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <header>
        <?= $this->render('blocks/header'); ?>
    </header>
    <section>
        <div class="flex-column">
            <div class="header__title_img text-center lh-1">
                <div class="container">
                    <img src="/img/about-heading-bg.webp" style="width: 350px; height: 40px;"
                         alt="Орнамент Соколиное Гнездо">
                    <h2 class="fs-1"><?= Html::encode($this->title) ?></h2>
                    <h3 class="text-white">гостевой дом</h3>
                </div>
            </div>
        </div>
    </section>
    <main class="main">
        <?= $content ?>
        <?= ContentWidget::widget(['template' => 'otzovy', 'cat_id' => 34]) ?>
        <?= FeedbackWidget::widget() ?>
    </main>
    <footer class="footer mt-auto">
        <?= $this->render('blocks/footer'); ?>
    </footer>
    <script src="/js/jquery.magnific-popup.js"></script>
    <script src="/js/main.min.js"></script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
