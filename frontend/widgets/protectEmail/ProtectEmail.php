<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 07.09.15
 * Time: 12:10
 */

namespace frontend\widgets\protectEmail;

use yii\base\Widget;

/**
 * [[ProtectEmail|email=info@marinsgroup.ru]]
 */
class ProtectEmail extends Widget
{
    /**
     * email block
     * @var
     */
    public $email = null;

    public function run()
    {
        if ($this->email) {
            return $this->render('index', [
                'random' => uniqid('', false),
                'email' => $this->email
            ]);
        }
        return 'Задайте email.';
    }
}
