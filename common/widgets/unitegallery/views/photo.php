<?php if($data): ?>
    <div id="<?=$id?>" style="display:none;">
        <?php foreach($data as $item): ?>
            <img src="<?=Yii::$app->params['gallery']['urlDir'].$item['gallery'].'/'.$item['name']?>" data-image="<?=Yii::$app->params['gallery']['urlDir'].$item['gallery'].'/'.'max_'.$item['name']?>">
        <?php endforeach; ?>
    </div>
<?php endif; ?>