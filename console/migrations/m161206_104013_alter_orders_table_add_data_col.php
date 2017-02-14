<?php

use yii\db\Migration;

class m161206_104013_alter_orders_table_add_data_col extends Migration
{
    public function up()
    {
        $this->addColumn('{{%orders}}', 'data', $this->text()->defaultValue(null).' AFTER `status`');
    }

    public function down()
    {
        echo "m161206_104013_alter_orders_table_add_data_col cannot be reverted.\n";

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
