<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 01.04.15
 * Time: 15:21
 */

namespace backend\widgets\WidgetTopMenu;

use Yii;
use yii\base\Widget;
use yii\db\Query;
use yii\bootstrap\Nav;

class WidgetTopMenu extends Widget {
    public function run()
    {
        $row = (new Query())
            ->select('id,title')
            ->from('{{%content_categories}}')
            ->all();

        $menuItems = [];
        if (Yii::$app->user->can('administrator')) {
            $menuItems = [
                ['label' => 'Главная', 'url' => ['/site']],
//                ['label' => 'Пользователи', 'url' => ['/user/admin']],
//                ['label' => 'Категории', 'url' => ['/content-categories']],
                ['label' => 'Статичные страницы','url' => ['/content/index', 'cat' => 1]],
                ['label' => 'Материалы', 'items' =>[
                    ['label' => 'Галереи','url' => ['/content/index', 'cat' => 30]],
                    ['label' => 'Описание','url' => ['/content/index', 'cat' => 31]],
                    ['label' => 'Услуги и правила на главной странице ','url' => ['/content/index', 'cat' => 32]],
                    ['label' => 'Отзывы','url' => ['/content/index', 'cat' => 34]],
                    ]],
                ['label' => 'Новости и акции','url' => ['/content/index', 'cat' => 33]],
                ['label' => 'Номера и апартаменты', 'items' => [
                    ['label' => 'План этажа','url' => ['/content/index', 'cat' => 25]],
                    ['label' => 'Первый этаж','url' => ['/content/index', 'cat' => 24]],
                    ['label' => 'Второй этаж','url' => ['/content/index', 'cat' => 26]],
                    ['label' => 'Третий этаж','url' => ['/content/index', 'cat' => 27]],
                    ['label' => 'Четвертый этаж','url' => ['/content/index', 'cat' => 28]],
                    ['label' => 'Пятый этаж','url' => ['/content/index', 'cat' => 29]],
                ]],
//                ['label' => 'Текстовые блоки', 'url' => ['/content-block']],
                ['label' => 'Рассылки', 'url' => ['/mailings']],
            ];
        }

        if(!Yii::$app->user->isGuest){
            $menuItems[] =
                ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/user/security/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ]
            ;
        }

        echo Nav::widget([
            'activateParents'=>true,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
    }
} 