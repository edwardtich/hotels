<?php
if($item['seo_title']) $this->title = $item['seo_title'];
else $this->title = $item['title'];

if($item['seo_description'])
    $this->registerMetaTag(['name' => 'description', 'content' => $item['seo_description']], 'description');
else $this->registerMetaTag(['name' => 'description', 'content' =>$item['title']], 'description');

if($item['seo_keywords'])
    $this->registerMetaTag(['name' => 'keywords', 'content' => $item['seo_keywords']], 'keywords');
else $this->registerMetaTag(['name' => 'keywords', 'content' =>$item['title']], 'keywords');
?>