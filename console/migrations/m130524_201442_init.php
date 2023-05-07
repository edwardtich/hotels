<?php
use yii\db\Migration;
use dektrium\user\models\User;


class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->insert('{{%auth_item}}',[
            'name' => 'administrator',
            'type' => 1,
            'description'=>'Доступ в административную панель',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('{{%auth_assignment}}',[
            'item_name' => 'administrator',
            'user_id' => 1,
            'created_at' => time()
        ]);

        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
            'email'    => 'gerasinig@marinsgroup.ru',
            'username' => 'diir2015',
            'password' => '123456',
        ]);
        $user->create();

    }

//    public function down()
//    {
//        $this->dropTable('{{%user}}');
//    }
}
