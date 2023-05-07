<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 22.09.15
 * Time: 18:11
 */

namespace common\widgets\cropper;

use kartik\file\FileInput;
use Yii;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;
use yii\web\View;


/**
 * Надстройка над полем загрузки изобр. (FileInput). Добавляет функционал cropper.
 * */
class FileInputCropper extends FileInput
{

    /**
     * @var Атрибут модели
     */
    public $cropAttribute;

    /**
     * @var Имя input
     */
    public $cropName;

    /**
     * Настройка кропа (можно взять из confg)
     * 'dir'=>'@frontend/web/upload/content/',
     * 'urlDir'=>'/upload/content/',
     * 'defaultCrop' => [100,75],
     * 'crop'=>[
     *   [850,0,'nw'],
     *   [850,480,'in']
     * ]
     * @var array
     */
    public $cropConfig = [];

    /**
     * @var id input в котором передается данные js cropper
     */
    private $cropIdInput;

    /**
     * @var array initialize the FileInput widget
     */
    public function init()
    {
        if (!$this->cropConfig) throw new ServerErrorHttpException('FileInputCropper :: Укажите cropConfig.');
        $this->registerClientScript();

        if ($this->cropAttribute) $this->cropIdInput = $this->cropAttribute;
        else $this->cropIdInput = $this->cropName;

        Yii::$app->view->registerJs('var dataCropper = {}', View::POS_HEAD, $this->cropIdInput);
        $this->pluginEvents = [
            "fileloaded" => "function(event, file, previewId, index, reader){
                    function cropImg(title,w,h){
                          var URL = window.URL || window.webkitURL;
                          blobURL = URL.createObjectURL(file);
                            var img = '<img src=\"'+ blobURL +'\" style=\"max-width: 868px;\" />';
                            $('#" . $this->cropIdInput . "_' + title).html(img);
                            cropOptions = {
                                center: true,
                                autoCropArea: 1,
                                minContainerWidth:868,
                                minContainerHeight:600,
                                crop: function() {
                                    e = $(this).cropper('getData', true);
                                    if(e.width < w ||  e.height < h)$('.'+ title +'-img-error').html('w:' + Math.round(e.width) + ' ' + 'h:' + Math.round(e.height));
                                    else  $('.'+ title +'-img-error').html('');
                                    dataCropper[title] = e;
                                    $('#" . $this->cropIdInput . "').val(JSON.stringify(dataCropper));
                                },
                            };
                            if(w != 0 && h != 0) cropOptions.aspectRatio = w / h;
                            $('#" . $this->cropIdInput . "_' + title + ' img').cropper(cropOptions);
                    }
                    " . $this->cropJs() . "
            }",
            "fileclear" => "function(event){
                $('#" . $this->cropIdInput . "').val('');
                $('#" . $this->cropIdInput . " .cropper-img-container').html('Загрузите сначала изображение.');
            }"
        ];

        parent::init();
    }

    public function run()
    {
        if ($this->hasModel() && $this->cropAttribute) {
            $cropInput = Html::activeHiddenInput($this->model, $this->cropAttribute, ['id' => $this->cropAttribute]);
        } elseif ($this->cropName) {
            $cropInput = Html::hiddenInput($this->cropName, '', ['id' => $this->cropName]);
        } else throw new ServerErrorHttpException('FileInputCropper :: Укажите cropAttribute (атрибут модели) или cropName (имя input).');
        return $this->render('index', ['cropInput' => $cropInput, 'cropConfig' => $this->cropConfig, 'cropIdInput' => $this->cropIdInput]);
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);
    }

    /**
     * Устанавливает функцию js функцию cropImg в зависимости от настроек виджета (см. свойство cropConfig).
     * @return string
     */
    public function cropJs()
    {
        $cropJs = '';
        if ($this->cropConfig) {
            if ($this->cropConfig['defaultCrop'])
                $cropJs = "cropImg('defaultCrop'," . $this->cropConfig['defaultCrop'][0] . "," . $this->cropConfig['defaultCrop'][1] . ");";
            if ($this->cropConfig['crop']) {
                foreach ($this->cropConfig['crop'] as $item) {
                    $cropJs .= "cropImg('" . $item[2] . "'," . $item[0] . "," . $item[1] . ");";
                }
            }
        }
        return $cropJs;
    }
}
