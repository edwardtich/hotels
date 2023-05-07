<?php

use yii\db\Migration;

/**
 * Class m220131_121226_1
 */
class m220131_121226_add_column_redactor_to_content_block_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%content_block}}', 'redactor', $this->integer(1)->after('text')->defaultValue(1)->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%content_block}}', 'redactor');
    }
}
