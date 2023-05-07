<?php

/** @var $items array */
/** @var $category string */

/** @var $pagination yii\data\Pagination */

use yii\widgets\LinkPager;

$this->title = $items[0]['cat_seo_title'] ?: $items[0]['cat_title'];

$this->registerMetaTag(['name' => 'description', 'content' => $items[0]['cat_seo_description'] ?: $items[0]['cat_title']], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $items[0]['cat_seo_keywords'] ?: $items[0]['cat_title']], 'keywords');

$this->registerLinkTag(['rel' => 'canonical', 'href' => \frontend\models\Content::urlCanonicalCategory($category)]);
?>
<!--    <section id="content-block">-->
<!--        <div class="container">-->
<!--            <div class="content-text z-depth-3">-->
<!--                --><?php //if ($items) {
//                    foreach ($items as $vacancy): { ?><!--<br>-->
<!--                        <details class="accordion">-->
<!--                            <summary class="accordion__control">-->
<!--                                <h3 class="accordion__title"-->
<!--                                    id="vak_--><?//= $vacancy['id'] ?><!--">--><?//= $this->context->decodeWidgets($vacancy['title']); ?><!--</h3>-->
<!--                                <span class="accordion__icon"></span>-->
<!--                            </summary>-->
<!--                            <div class="accordion__content">-->
<!--                                --><?//= $this->context->decodeWidgets($vacancy['text']); ?>
<!--                        </details>-->
<!---->
<!--                    --><?php //}
//                    endforeach;
//                } else {
//                    echo 'В настоящее время нет вакансии.';
//                }
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
<?php Yii::$app->view->registerJs('
const details = document.querySelectorAll("details");

// Add the onclick listeners.
details.forEach((targetDetail) => {
  targetDetail.addEventListener("click", () => {
    details.forEach((detail) => {
      if (detail !== targetDetail) {
        detail.removeAttribute("open");
      }
    });
  });
});
') ?>