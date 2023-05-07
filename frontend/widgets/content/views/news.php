<?php
/** @var View $this */

/** @var $items array */

use frontend\models\Content;
use yii\web\View;

?>
<section class="mt-100 main__content_news container-fluid" id="event">
    <p class="text-center m-0">
        <img src="/img/resort-title-heading.png" width="390" height="40">
    </p>
    <h3 class="fs-sm-22 text-center">
        Новости & Акции
    </h3>
    <div class="row">
        <?php foreach ($items as $item) :{ ?>
            <?php $date = $item['date'];
            $time = strtotime($date);
            $newformat = date('d F Y', $time); ?>
            <div class="block_news col-sm-4 mb-5">
                <div class="block_news_img"
                     style="background-image: url(<?= Yii::$app->params['content']['logo']['urlDir'] . 'max_' . $item['logo'] ?>);">
                    <div class="block_news_text">
                        <span class="block_news_link_icon">
                            <a class="text-decoration-none" href="<?= Content::url($item) ?>">
                                <i class="fa-chain"></i>
                            </a>
                        </span>
                        <div class="block_news_content">
                            <div class="entry-meta">
                                <span class="entry-date"><?= $newformat ?></span>
                            </div>
                            <h4 class="entry-title">
                                <a class="text-decoration-none" href="<?= Content::url($item) ?>"><?= $item['title'] ?></a>
                            </h4>
                            <br>
                            <?= $item['text'] ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } endforeach; ?>
    </div>
</section>
