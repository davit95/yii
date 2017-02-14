<?php

use yii\db\Migration;

class m161121_115824_alter_orders_table extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_orders_product_id', '{{%orders}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('fk_orders_voucher_id', '{{%orders}}', 'voucher_id', '{{%vouchers}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        echo "m161121_115824_alter_orders_table cannot be reverted.\n";

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
