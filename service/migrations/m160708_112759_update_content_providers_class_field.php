<?php

use yii\db\Migration;
use yii\db\Expression;

class m160708_112759_update_content_providers_class_field extends Migration
{
    public function up()
    {
        $this->execute('UPDATE {{%content_providers}} SET `class` = REPLACE(`class`, "service\\\components", "service\\\components\\\contents")');
    }

    public function down()
    {
        echo "m160708_112759_update_content_providers_class_field cannot be reverted.\n";

        return false;
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
