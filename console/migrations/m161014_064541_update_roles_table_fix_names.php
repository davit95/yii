<?php

use yii\db\Migration;

class m161014_064541_update_roles_table_fix_names extends Migration
{
    public function up()
    {
        $this->update('{{%roles}}', ['name' => 'user'], ['id' => 1]);
        $this->update('{{%roles}}', ['name' => 'admin'], ['id' => 2]);
    }

    public function down()
    {
        echo "m161014_064541_update_roles_table_fix_names cannot be reverted.\n";

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
