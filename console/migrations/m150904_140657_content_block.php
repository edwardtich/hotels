<?php

use yii\db\Schema;
use yii\db\Migration;

class m150904_140657_content_block extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%content_block}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'text' => Schema::TYPE_TEXT,
            'create_user_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'update_user_id' => Schema::TYPE_INTEGER . '(10)',
            'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%content_block}}');
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
