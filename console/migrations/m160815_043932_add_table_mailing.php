<?php

use yii\db\Schema;
use yii\db\Migration;

class m160815_043932_add_table_mailing extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mailings}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) COMMENT "заголовок письма"',
            'name_form' => Schema::TYPE_STRING . '(255) COMMENT "форма рассылки"',
            'mails' => Schema::TYPE_STRING . '(255) COMMENT "список e-mail для рассылки через звпятую"'
        ], $tableOptions);

        $this->insert('{{%mailings}}',[
            'title' => 'Заявка на аренду помещения (НОРА)',
            'name_form' => 'arenda',
            'mails' => 'gerasinig@marinsgroup.ru',
        ]);

        $this->insert('{{%mailings}}',[
            'title' => 'Заявка на вакансию (НОРА)',
            'name_form' => 'jobs',
            'mails' => 'gerasinig@marinsgroup.ru',
        ]);

        $this->insert('{{%mailings}}',[
            'title' => 'Вопрос c сайта НОРА',
            'name_form' => 'feedback',
            'mails' => 'gerasinig@marinsgroup.ru',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%mailings}}');
    }
}
