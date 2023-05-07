<?php if($data): ?>
    <div id="<?=$id?>">
        <?php foreach($data as $item): ?>
        <div data-type="youtube"
             data-title="<?=$item['title'];?>"
             data-description="<?=$item['description'];?>"
             data-thumb="https://i.ytimg.com/vi/<?=$item['code'];?>/mqdefault.jpg"
             data-image="https://i.ytimg.com/vi/<?=$item['code'];?>/sddefault.jpg"
             data-videoid="<?=$item['code'];?>" ></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>