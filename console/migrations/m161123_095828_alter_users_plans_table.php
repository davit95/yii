<?php

use yii\db\Migration;

class m161123_095828_alter_users_plans_table extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%users_plans}}', 'type', 'product_type');
    }

    public function down()
    {
        echo "m161123_095828_alter_users_plans_table cannot be reverted.\n";

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
