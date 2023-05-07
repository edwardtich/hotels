<?php

use yii\db\Schema;
use yii\db\Migration;

class m150325_163700_content extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%content}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(255) NOT NULL',
            'cat' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'text' => Schema::TYPE_TEXT,
            'img' => Schema::TYPE_STRING . '(255)',
            'date'=> Schema::TYPE_DATETIME,
            'status' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 1',
            'sort' => Schema::TYPE_INTEGER . '(10)',
            'gallery' => Schema::TYPE_STRING . '(255)',
            'seo_title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'seo_description' => Schema::TYPE_STRING . '(255) NOT NULL',
            'seo_keywords' => Schema::TYPE_STRING . '(255) NOT NULL',
            'create_user_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'update_user_id' => Schema::TYPE_INTEGER . '(10)',
            'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%content}}');
    }

}
