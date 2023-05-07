<?php

namespace common\components;

use vova07\imperavi\actions\UploadFileAction;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use Intervention\Image\ImageManager;


class UploadActionImperavi extends UploadFileAction
{
    private $_validator = 'image';

    public $imgCrop = '1200';

    public function run()
    {
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName($this->uploadParam);
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', $this->_validator, $this->validatorOptions)->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file')
                ];
            } else {
                if ($this->unique === true && $model->file->extension) {
                    $model->file->name = uniqid() . '.' . $model->file->extension;
                }
                $manager = new ImageManager(array('driver' => 'gd'));
                $img = $manager->make($file->tempName);
                if (Yii::$app->params['redactor']['cropImg']) {
                    $this->imgCrop = Yii::$app->params['redactor']['cropImg'];
                }
                $img->widen($this->imgCrop, function ($constraint) {
                    $constraint->upsize();
                });
                if ($img->save($this->path . $model->file->name)) {
                    $result = ['filelink' => $this->url . $model->file->name];
                    if ($this->uploadOnlyImage !== true) {
                        $result['filename'] = $model->file->name;
                    }
                } else {
                    $result = [
                        'error' => Yii::t('imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')
                    ];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }
} 