<?php
use yii\bootstrap\Modal;
if(!function_exists('modal')){
    function modal($title,$w,$h,$cropIdInput){
        if($title && isset($w) && isset($h)){
            $text = 'Crop '.$w.'x'.$h;
            Modal::begin([
                'header' => '<h3>'.$text.'<span class="'.$title.'-img-error pull-right" style="color:red;"></span></h3>',
                'toggleButton' => ['label' => $text,'class'=>'btn'],
                'size'=>'modal-lg'
            ]);
            echo '<div id="'.$cropIdInput.'_'.$title.'" class="cropper-img-container">Загрузите сначала изображение.</div>';
            Modal::end();
        }
    }
}
?>
<div style="margin: 15px 0">
<?php
if($cropConfig){
    if($cropConfig['defaultCrop']){
        modal('defaultCrop',$cropConfig['defaultCrop'][0],$cropConfig['defaultCrop'][1],$cropIdInput);
    }

    if($cropConfig['crop']){
        foreach($cropConfig['crop'] as $item){
            modal($item[2],$item[0],$item[1],$cropIdInput);
        }
    }
}

echo $cropInput;
?>
</div>
