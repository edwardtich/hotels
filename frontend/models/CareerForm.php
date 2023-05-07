<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 12.02.16
 * Time: 16:04
 */

namespace frontend\models;

use yii\base\Model;

class CareerForm extends Model
{
    public $name;
    public $second_name;
    public $last_name;
    public $phone;
    public $email;
    public $body;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'second_name', 'last_name', 'phone', 'email'], 'required'],
            ['phone', 'match', 'pattern' => '/[0-9\-()+]\w*$/i'],
            ['body', 'string'],
            ['email', 'email'],
            //['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => ' Имя',
            'second_name' => 'Отчество',
            'last_name' => 'Фамилия',
            'email' => 'Email',
            'phone' => 'Телефон',
            'body' => 'Ваше резюме'
        ];
    }
}
