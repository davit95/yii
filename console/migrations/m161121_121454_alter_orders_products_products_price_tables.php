<?php

use yii\db\Migration;

class m161121_121454_alter_orders_products_products_price_tables extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%orders}}', 'updated', $this->integer(11)->defaultValue(null));
        $this->alterColumn('{{%products}}', 'updated', $this->integer(11)->defaultValue(null));
    }

    public function down()
    {
        echo "m161121_121454_alter_orders_products_products_price_tables cannot be reverted.\n";

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
