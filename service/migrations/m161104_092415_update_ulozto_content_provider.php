<?php

use yii\db\Migration;

class m161104_092415_update_ulozto_content_provider extends Migration
{
    public function up()
    {
        $this->update('{{%content_providers}}', ['auth_url' => 'https://www.ulozto.net/login'], ['name' => 'ulozto.net']);
    }

    public function down()
    {
        echo "m161104_092415_update_ulozto_content_provider cannot be reverted.\n";

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
