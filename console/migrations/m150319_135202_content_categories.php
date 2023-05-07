<?php

use yii\db\Schema;
use yii\db\Migration;

class m150319_135202_content_categories extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%content_categories}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255)',
            'alias' => Schema::TYPE_STRING . '(255)',
            'description' => Schema::TYPE_TEXT,
            'img' => Schema::TYPE_STRING . '(255)',
            'template' => Schema::TYPE_STRING . '(255)',
            'date'=> Schema::TYPE_DATETIME,
            'status' => Schema::TYPE_INTEGER . '(1) NOT NULL DEFAULT 1',
            'seo_title' => Schema::TYPE_STRING . '(255)',
            'seo_description' => Schema::TYPE_STRING . '(255)',
            'seo_keywords' => Schema::TYPE_STRING . '(255)',
            'create_user_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'update_user_id' => Schema::TYPE_INTEGER . '(10)',
            'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER
        ], $tableOptions);

        $this->insert('{{%content_categories}}',[
            'title' => 'Статичные страницы',
            'alias' => 'static',
            'description' => 'Категория для статичных страниц.',
            'img' => '',
            'template' => 'static',
            'date'=> date('Y-m-d H:i:s'),
            'status' => '1',
            'seo_title' => '',
            'seo_description' => '',
            'seo_keywords' => '',
            'create_user_id' => 1,
            'update_user_id' => 1,
            'create_time' => time(),
            'update_time' => ''
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%content_categories}}');
    }
}
