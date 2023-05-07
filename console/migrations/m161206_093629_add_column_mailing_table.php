<?php

use yii\db\Migration;

class m161206_093629_add_column_mailing_table extends Migration
{
    public function up()
    {
        $this->addColumn('mailings', 'email_from', 'varchar(50) DEFAULT "" COMMENT "e-mail в поле from письма"');
    }

    public function down()
    {
        $this->dropColumn('mailings', 'email_from');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
