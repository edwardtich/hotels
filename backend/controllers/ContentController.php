<?php

namespace backend\controllers;

use Yii;
use backend\models\Content;
use backend\models\search\ContentSearch;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Intervention\Image\ImageManager;
use yii\helpers\FileHelper;
use yii\db\Query;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

/**
 * ContentController implements the CRUD actions for Content model.
 */
class ContentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'common\components\UploadActionImperavi',
                'url' => Yii::$app->params['contentRedactor']['url'], // Directory URL address, where files are stored.
                'path' => Yii::$app->params['contentRedactor']['path'] // Or absolute path to directory where files are stored.
            ],
        ];
    }

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws InvalidConfigException
     */
    public function actionCreate($cat = null)
    {
        $model = new Content();
        $model->status = 1;
        $model->date = Yii::$app->formatter->asDate('now', 'php:d-m-Y');
        $model->gallery = uniqid('', false);
        $model->cat = $cat;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->date = Yii::$app->formatter->asDate($model->date, 'php:d-m-Y');
        if (empty($model->gallery)) {
            $model->gallery = uniqid('', false);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete() && $model->gallery) {
            $dir = Yii::getAlias(Yii::$app->params['gallery']['dir'] . $model->gallery);
            $this->deleteGalleryDir($dir);
            $this->deleteGalleryDb($model->gallery);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Удаляет папку галереи.
     * @param $dir
     */
    public function deleteGalleryDir($dir)
    {
        if (file_exists($dir)) {
            FileHelper::removeDirectory($dir);
        }
    }

    /**
     * Удаляет галерею из базы данных
     * @param $gallery
     */
    private function deleteGalleryDb($gallery)
    {
        (new Query())->createCommand()->delete('{{%content_gallery}}', ['gallery' => $gallery])->execute();
    }

    /**
     * Удаляет фотографии из галереи и из базы
     * @param $id
     * @return string
     */
    public function actionDeleteGallery($id)
    {
        $query = new Query();
        $row = $query->select('id,gallery,name')
            ->from('{{%content_gallery}}')
            ->where(['id' => $id])->one();
        if ($row) {
            $response = [];
            $fileDefault = Yii::getAlias(Yii::$app->params['gallery']['dir'] . $row['gallery'] . '/' . $row['name']);
            $fileMax = Yii::getAlias(Yii::$app->params['gallery']['dir'] . $row['gallery'] . '/max_' . $row['name']);
            $fileMin = Yii::getAlias(Yii::$app->params['gallery']['dir'] . $row['gallery'] . '/min_' . $row['name']);

            if (file_exists($fileDefault)) {
                if (unlink($fileDefault)) {
                    $query->createCommand()->delete('{{%content_gallery}}', ['id' => $id])->execute();
                    $response['files'] = [$row['name'] => true];
                } else {
                    $response['files'] = [$row['name'] => false];
                }
            }
            if (file_exists($fileMax)) unlink($fileMax);
            if (file_exists($fileMin)) unlink($fileMin);

            return json_encode($response);
        }
    }

    /**
     * Загружает фотографии в галерею и записывает данные в базу
     * @return array
     */
    public function actionUploadGallery()
    {
        $model = new Content();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = [];

        if (Yii::$app->request->isPost) {
            $model->images = UploadedFile::getInstance($model, 'images');
            if ($model->images && $model->validate(['images'])) {
                $gallery = Yii::$app->request->get('gallery');
                $file = $this->cropGallery($model->images->tempName, $model->images->extension, $gallery);

                $query = new Query();
                $query->createCommand()->insert('{{%content_gallery}}', [
                    'gallery' => $gallery,
                    'name' => $file['fileName'],
                    'create_user_id' => Yii::$app->user->id,
                    'create_time' => time()
                ])->execute();

                if ($file) {
                    $response['files'][] = [
                        'name' => $file['fileName'],
                        'type' => $model->images->extension,
                        'size' => $model->images->size,
                        'url' => Yii::$app->params['gallery']['urlDir'] . $gallery . '/max_' . $file['fileName'],
                        'thumbnailUrl' => Yii::$app->params['gallery']['urlDir'] . $gallery . '/' . $file['fileName'],
                        'deleteUrl' => Url::toRoute(['content/delete-gallery', 'id' => Yii::$app->db->getLastInsertID()]),
                        'deleteType' => 'POST'
                    ];
                } else {
                    $response['files'][] = [
                        "name" => $model->images->baseName,
                        "size" => $model->images->size,
                        "error" => 'Не удалось загрузить фаил (ошибка 500)',
                        "info" => $file
                    ];
                }
            } else {
                $response['files'][] = [
                    "name" => $model->images->baseName,
                    "size" => $model->images->size,
                    "error" => 'Не удалось загрузить фаил.' . $model->errors['images'][0],
                    "info" => $model->errors['images'],
                ];
            }
        }

        return $response;
    }

    /**
     * Выводит текущие зилитые изобрвжения из базы
     * @return mixed
     */
    public function actionShowGallery($gallery)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = (new Query())->from('{{%content_gallery}}')
            ->select('id,gallery,name,create_time')
            ->where(['gallery' => $gallery])
            ->all();
        $files = [];
        foreach ($data as $item) $files[] = [
            'name' => $item['name'],
            'thumbnailUrl' => Yii::getAlias(Yii::$app->params['gallery']['urlDir'] . $item['gallery'] . '/' . $item['name']),
            'deleteUrl' => Url::toRoute(['content/delete-gallery', 'id' => $item['id']]),
            'deleteType' => 'POST'
        ];

        $response['files'] = $files;
        return $response;
    }

    /**
     * Функция загрузки и кропа изображений
     * @param $tmpFile - временный фаил
     * @param $extensionFile - расширение файла
     * @param $gallery_dir - дирректория галлереи
     * @return array
     */
    private function cropGallery($tmpFile, $extensionFile, $gallery_dir)
    {
        $dir = Yii::getAlias(Yii::$app->params['gallery']['dir'] . $gallery_dir . '/');
        FileHelper::createDirectory($dir);
        $filename = uniqid() . '.' . $extensionFile;
        if (Yii::$app->params['gallery']['dir']) {
            $this->cropGalleryImgPrefix('default', $tmpFile, $dir, $filename, $extensionFile);
            $this->cropGalleryImgPrefix('min', $tmpFile, $dir, $filename, $extensionFile);
            $this->cropGalleryImgPrefix('max', $tmpFile, $dir, $filename, $extensionFile);
        }
        return ['dir' => $dir, 'fileName' => $filename];
    }

    /**
     * Кроп изображений по размерам
     * @param $tmpFile временный фаил
     * @param $fileName
     * @param $w
     * @param $h
     * @param $type тип кропа
     */
    private function cropImg($tmpFile, $fileName, $w, $h, $type)
    {
        $manager = new ImageManager(array('driver' => 'gd'));
        $img = $manager->make($tmpFile);
        if ($type == 'widen') {
            $img->widen($w, function ($constraint) {
                $constraint->upsize();
            });
        } elseif ($type == 'fit') {
            $img->fit($w, $h);
        }
        $img->save($fileName);
    }

    /**
     * Кроп изображений и сохранение с перфиксами
     * Ширина и высота изображений берется из конфигурационного файла:
     * 'gallery'=>[
     *       'dir'=>'@frontend/web/upload/gallery/',
     *       'urlDir'=>'/upload/gallery/',
     *       'default'=>['w'=>200,'h'=>130,'type'=>'fit'],
     *       'min'=>['w'=>1000,'h'=>700,'type'=>'fit'],
     *       'max'=>['w'=>1200,'h'=>900,'type'=>'widen']
     * ]
     * @param $prefix - min,max ...
     * @param $tmpFile
     * @param $dir
     * @param $filename
     * @param $extensionFile
     */
    private function cropGalleryImgPrefix($prefix, $tmpFile, $dir, $filename, $extensionFile)
    {
        if ($prefix && $tmpFile && $extensionFile) {
            $prefix === 'default' ? $prefixFile = '' : $prefixFile = $prefix . '_';
            $file = $dir . $prefixFile . $filename;

            if (Yii::$app->params['gallery'][$prefix] && Yii::$app->params['gallery'][$prefix]['w'] && Yii::$app->params['gallery'][$prefix]['h'] && Yii::$app->params['gallery'][$prefix]['type']) {
                $this->cropImg(
                    $tmpFile,
                    $file,
                    Yii::$app->params['gallery'][$prefix]['w'],
                    Yii::$app->params['gallery'][$prefix]['h'],
                    Yii::$app->params['gallery'][$prefix]['type']
                );
            }
        }
    }

}
