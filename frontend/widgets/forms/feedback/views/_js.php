<?php
use yii\helpers\Url;

Yii::$app->view->registerJs('
    $("body").on("beforeSubmit","form.feeadback",function (){
        var form = $(this);
        if(form.find(".has-error").length) {
            return false;
        }else{
            $.ajax({
                url: "'.Url::toRoute(['site/feedback']).'",
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                success: function(data){
                    form[0].reset();
                    Materialize.toast(data.message, 4000);
                }
            });
        }
        return false;
    });

    $(".sendFeeadback").on("click",function(){
        $(this).parents("form").submit();
    });
');