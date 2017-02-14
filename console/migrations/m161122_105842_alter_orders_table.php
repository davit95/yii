<?php

use yii\db\Migration;

class m161122_105842_alter_orders_table extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%orders}}', 'status', 'ENUM("COMPLETED", "PENDING", "ERROR", "CANCELED") NOT NULL');
        $this->addColumn('{{%orders}}', 'notification_data', $this->text()->defaultValue(null).' AFTER `status`');
    }

    public function down()
    {
        echo "m161122_105842_alter_orders_table cannot be reverted.\n";

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
