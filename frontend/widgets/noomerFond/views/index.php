<?php

/** @var $room array */

?>
<style>
    .accordion-item {
        background: #fff !important;
        border: 1px solid #e8eff1 !important;
        border-radius: 4px !important;
        margin-bottom: 10px !important;
    }

    .accordion-button {
        padding: 17px 30px 17px 15px !important;
        background: #f6fafb !important;
        color: #4b5981 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        font-size: 14px !important;
        font-weight: bolder !important;
    }

    .room_et_title {
        font-family: "Fira Sans", serif;
        color: #e1ad4f !important;
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 16px;
    }
</style>
<div class="accordion accordion-flush w-100" id="accordionFlushExample">
    <?php foreach ($room as $key => $item):{ ?>
        <div class="accordion-item">
            <div class="accordion-header" id="flush-heading_<?= $item[0]['id'] ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse_<?= $item[0]['id'] ?>" aria-expanded="false"
                        aria-controls="flush-collapse_<?= $item[0]['id'] ?>">
                    <i class="fa fa-arrow-circle-o-right"></i>&nbsp;<?= $key ?>
                </button>
            </div>
            <div id="flush-collapse_<?= $item[0]['id'] ?>" class="accordion-collapse collapse"
                 aria-labelledby="flush-heading_<?= $item[0]['id'] ?>"
                 data-bs-parent="#accordionFlushExample">
                <div class="accordion-body row">
                    <?php foreach ($item as $i):{ ?>
                        <div class="col-md-5">
                            <h4 class="room_et_title text-start"><?= $i['number'] ?></h4>
                            <div class="text-start"><?= $i['description'] ?></div>
                        </div>
                        <div class="col-md-7">
                            <?= \frontend\widgets\PhotoSlider\PhotoSlider::widget(['gallery' => $i['gallery'], 'view' => 'rooms']) ?>
                        </div>
                    <?php } endforeach; ?>
                </div>
            </div>
        </div>
    <?php }
    endforeach; ?>
</div>
<script>
    $(document).ready((function () {
        $(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            center: true,
            autoplay: true,
            lazyLoad: true,
        })
    }));
</script>