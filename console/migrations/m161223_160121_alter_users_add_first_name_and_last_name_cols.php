<?php

use yii\db\Migration;

class m161223_160121_alter_users_add_first_name_and_last_name_cols extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'first_name', $this->string(200)->defaultValue(null).' AFTER `email`');
        $this->addColumn('{{%users}}', 'last_name', $this->string(200)->defaultValue(null).' AFTER `first_name`');
    }

    public function down()
    {
        echo "m161223_160121_alter_users_add_first_name_and_last_name_cols cannot be reverted.\n";

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
