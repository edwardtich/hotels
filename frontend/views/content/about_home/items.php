<?php

/** @var $item array */

$this->title = $item['seo_title'] ?: $item['title'];

$this->registerMetaTag(['name' => 'description', 'content' => $item['seo_description'] ?: $item['title']], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $item['seo_keywords'] ?: $item['title']], 'keywords');
//$this->registerLinkTag(['rel' => 'canonical', 'href' => \frontend\models\Content::urlCanonical($item)]);
?>


