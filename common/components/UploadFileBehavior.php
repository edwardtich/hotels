<?php
/**
 * @link https://github.com/himiklab/yii2-upload-file-behavior
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace common\components;

use Yii;
use yii\base\Behavior;
use yii\helpers\Json;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use Intervention\Image\ImageManager;

/**
 * Behavior for simplifies file upload
 *
 * For example:
 *
 * ```php
 * public function behaviors()
 * {
 *      return [
 *          'file' => [
 *              'class' => UploadFileBehavior::className(),
 *              'attributeName' => 'picture',
 *              'savePath' => '@webroot/uploads',
 *              'generateNewName' => true,
 *              'protectOldValue' => true,
 *              'defaultCrop' =>[width,height,type_crop (fit or widen)],
 *              'crop'=>[
 *                   [width,height,prefix,type_crop (fit or widen)],
 *                   [300,150,'min','fit'],
 *                   [600,300,'max','widen']
 *               ]
 *          ],
 *      ];
 * }
 * ```
 *
 * @author HimikLab
 */
class UploadFileBehavior extends Behavior
{
    /** @var string model file field name */
    public $attributeName = '';

    /**
     * Input в котором хранятся параметры для кропа.
     * @var string
     */
    public $cropCoordinatesAttrName = '';
    /**
     * @var string|callable path or alias to the directory in which to save files
     * or anonymous function returns directory path
     */
    public $savePath;
    /**
     * @var bool|callable generate a new unique name for the file
     * set true (@see self::generateFileName()) or anonymous function takes the old file name and returns a new name
     */
    public $generateNewName = false;

    /**
     * Базовый кроп
     *[850,480]
     * @var array
     */
    public $defaultCrop = [];

    /**
     * Дополнительный кроп
     * [
     *      [850,0,'nw','widen'],
     *      [850,480,'in','fit'],
     * ]
     * @var array
     */
    public $crop = [];

    /** @var bool erase protection the old value of the model attribute if the form returns empty string */
    public $protectOldValue = false;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function init()
    {
        if ($this->savePath instanceof \Closure) {
            $this->savePath = call_user_func($this->savePath);
        }
        $this->savePath = Yii::getAlias($this->savePath);
    }

    public function beforeValidate()
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;
        if ($file = UploadedFile::getInstance($model, $this->attributeName)) {
            $model->setAttribute($this->attributeName, $file);
        }
    }

    public function beforeInsert()
    {
        $this->loadFile();
    }

    public function beforeUpdate()
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;
        if ($model->getAttribute($this->attributeName) !== '') {
            $this->loadFile();
            return;
        }
        if ($this->protectOldValue) {
            $model->setAttribute(
                $this->attributeName,
                $model->getOldAttribute($this->attributeName)
            );
        }
    }

    public function beforeDelete()
    {
        $this->deleteFile();
    }

    protected function loadFile()
    {
        // delete the old version if it necessary
        $this->deleteFile();
        /** @var ActiveRecord $model */
        /** @var UploadedFile $file */
        $model = $this->owner;
        $file = $model->getAttribute($this->attributeName);
        if (!$file instanceof UploadedFile) {
            return;
        }
        $fileName = $file->name;

        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0755, true);
        }

        if ($this->generateNewName !== false) {
            $fileName = $this->generateNewName instanceof \Closure ? call_user_func($this->generateNewName, $fileName) : $this->generateFileName($file);
            $file->name = $fileName;
        }

        $this->defaultCrop($file, $fileName, $model);
        $this->crop($file, $fileName, $model);

        $model->setAttributes([$this->attributeName => $file]);
    }

    protected function deleteFile()
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;
        if (!$oldFileName = $model->getOldAttribute($this->attributeName)) {
            return;
        }
        $filePath = $this->savePath . DIRECTORY_SEPARATOR . $oldFileName;
        if (is_file($filePath)) {
            unlink($filePath);
        }

        if ($this->crop) {
            foreach ($this->crop as $item) {
                if (isset($item[2])) {
                    $filePath = $this->savePath . DIRECTORY_SEPARATOR . $item[2] . '_' . $oldFileName;
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }
            }
        }
    }

    protected function generateFileName(UploadedFile $file)
    {
        return uniqid() . '.' . $file->getExtension();
    }

    protected function defaultCrop($file, $fileName, $model)
    {
        if ($this->defaultCrop !== false && isset($this->defaultCrop[0]) && isset($this->defaultCrop[1])) {
            $manager = new ImageManager(array('driver' => 'gd'));
            $img = $manager->make($file->tempName);
            if ($this->cropCoordinatesAttrName && $model->{$this->cropCoordinatesAttrName}) {
                $cropOptions = json_decode($model->{$this->cropCoordinatesAttrName}, true);
                $cropOptionsDef = $cropOptions['defaultCrop'];
                $img->crop($cropOptionsDef['width'], $cropOptionsDef['height'], $cropOptionsDef['x'], $cropOptionsDef['y']);
                $this->cropWidenOrFit($this->defaultCrop[0], $this->defaultCrop[1], $img);
            } else {
                $this->cropWidenOrFit($this->defaultCrop[0], $this->defaultCrop[1], $img);
            }
            $img->save($this->savePath . DIRECTORY_SEPARATOR . $fileName);
        } else $file->saveAs($this->savePath . DIRECTORY_SEPARATOR . $fileName);
    }

    protected function crop($file, $fileName, $model)
    {
        if ($this->crop !== false && isset($this->defaultCrop[0]) && isset($this->defaultCrop[1])) {
            if (is_array($this->crop)) {
                $manager = new ImageManager(array('driver' => 'gd'));
                foreach ($this->crop as $item) {
                    if (!isset($item[0]) && !isset($item[1]) && !isset($item[2])) {
                        throw new ServerErrorHttpException('UploadFileBehavior: Задайте ширину , высоту и prefix для crop (измените либо в модели, либо в конфигурационном файле [850,450,"prefix"].)');
                    }
                    if ($this->cropCoordinatesAttrName && $model->{$this->cropCoordinatesAttrName}) {
                        $cropOptions = json_decode($model->{$this->cropCoordinatesAttrName}, true);
                        $img = $manager->make($file->tempName);
                        $img->crop($cropOptions[$item[2]]['width'],
                            $cropOptions[$item[2]]['height'],
                            $cropOptions[$item[2]]['x'],
                            $cropOptions[$item[2]]['y']
                        );
                        $this->cropWidenOrFit($item[0], $item[1], $img);
                    } else {
                        $img = $manager->make($file->tempName);
                        $this->cropWidenOrFit($item[0], $item[1], $img);
                    }
                    $img->save($this->savePath . DIRECTORY_SEPARATOR . $item[2] . '_' . $fileName);
                }
            }
        }
    }

    protected function cropWidenOrFit($w, $h, $img)
    {
        if ($w == 0 && $h == 0)
            throw new ServerErrorHttpException('UploadFileBehavior: Ширина и высота одновременно не могу быть равны 0 (измените либо в модели, либо в конфигурационном файле).)');
        elseif ($w !== 0 && $h !== 0) {
            $img->fit($w, $h);
        } elseif ($h == 0)
            $img->widen($w, function ($constraint) {
                $constraint->upsize();
            });
        //$img->widen($w);
        else $img->heighten($h);
    }
}