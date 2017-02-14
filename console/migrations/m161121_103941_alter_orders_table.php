<?php

use yii\db\Migration;

class m161121_103941_alter_orders_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%orders}}', 'product_id', $this->integer(11)->notNull().' AFTER `description`');
        $this->addColumn('{{%orders}}', 'voucher_id', $this->integer(11)->defaultValue(null).' AFTER `product_id`');
        $this->addColumn('{{%orders}}', 'created', $this->integer(11)->notNull());
        $this->addColumn('{{%orders}}', 'updated', $this->integer(11)->notNull());
    }

    public function down()
    {
        echo "m161121_103941_alter_orders_table cannot be reverted.\n";

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
