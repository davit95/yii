<?php

use yii\db\Migration;

class m161110_135318_alter_user_orders_table_add_voucher_id_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user_orders}}', 'voucher_id', $this->integer(11)->defaultValue(null).' AFTER `product_id`');

        $this->addForeignKey('fk_user_orders_voucher_id', '{{%user_orders}}', 'voucher_id', '{{%vouchers}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        echo "m161110_135318_alter_user_orders_table_add_voucher_id_column cannot be reverted.\n";

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
