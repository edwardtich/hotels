<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 12.02.16
 * Time: 16:04
 */

namespace frontend\models;
use yii\base\Model;

class Feedback extends Model{
    public $name;
    public $email;
    public $phone;
    public $topic;
    public $body;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'=>'Имя',
            'email'=>'Email',
            'phone'=>'Телефон',
            'body'=>'Текст сообщения'
        ];
    }
}
