<?php
namespace frontend\models;
use yii\base\Model;

class VacancyForm extends Model
{
    public $fio;
    public $phone;
    public $email;
    public $title;
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'phone', 'title'], 'required'],
            ['email', 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'email' => 'Email',
            'phone' => 'Телефон',
            'title' => 'Вакансия'
        ];
    }
    
}
