<?php

use yii\db\Migration;

class m161129_103752_alter_orders_table_change_status_column extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%orders}}', 'status', 'ENUM("COMPLETED","PENDING","PAUSED","ERROR","CANCELED") NOT NULL');
    }

    public function down()
    {
        echo "m161129_103752_alter_orders_table_change_status_column cannot be reverted.\n";

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
