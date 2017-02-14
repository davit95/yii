<?php

use yii\db\Migration;

class m160630_134132_update_content_providers_storable_field extends Migration
{
    public function up()
    {
        $this->update('{{%content_providers}}', ['storable' => 1]);
    }

    public function down()
    {
        echo "m160630_134132_update_content_providers_storable_field cannot be reverted.\n";

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
