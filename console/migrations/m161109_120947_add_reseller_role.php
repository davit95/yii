<?php

use yii\db\Migration;

class m161109_120947_add_reseller_role extends Migration
{
    public function up()
    {
        $this->insert('{{%roles}}', ['name' => 'reseller']);
    }

    public function down()
    {
        echo "m161109_120947_add_reseller_role cannot be reverted.\n";

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
