<?php

use yii\db\Migration;

class m160722_114337_alter_instances_table_add_storing_enabled_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%instances}}', 'storing_enabled', $this->boolean()->notNull()->defaultValue(1).' AFTER name');
    }

    public function down()
    {
        echo "m160722_114337_alter_instances_table_add_storing_enabled_column cannot be reverted.\n";

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
