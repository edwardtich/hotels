<?php
use yii\db\Schema;
use yii\db\Migration;

class m180125_042936_add_view_date extends Migration
{
    public function up()
    {
        $this->addColumn('content', 'is_date_hidden', Schema::TYPE_STRING . '(512)  DEFAULT \'0\' AFTER `date`');
    }

    public function down()
    {
        $this->dropColumn('content', 'is_date_hidden');
    }
}
