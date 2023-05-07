<?php
use yii\db\Schema;
use yii\db\Migration;

class m180208_094323_add_logo_content extends Migration
{
    public function up()
    {
        $this->addColumn('content', 'logo', Schema::TYPE_STRING . '(255) COMMENT "миниатюра" AFTER `text`');
    }

    public function down()
    {
        $this->dropColumn('content', 'logo');
    }
}
