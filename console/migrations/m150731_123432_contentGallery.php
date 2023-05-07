<?php

use yii\db\Schema;
use yii\db\Migration;

class m150731_123432_contentGallery extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%content_gallery}}', [
            'id' => Schema::TYPE_PK,
            'gallery' => Schema::TYPE_STRING . '(255) NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'create_user_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'update_user_id' => Schema::TYPE_INTEGER . '(10)',
            'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%content_gallery}}');
    }
}
