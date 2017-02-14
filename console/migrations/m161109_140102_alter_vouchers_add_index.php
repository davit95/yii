<?php

use yii\db\Migration;

class m161109_140102_alter_vouchers_add_index extends Migration
{
    public function up()
    {
        $this->createIndex('idx_vouchers_voucher', '{{%vouchers}}', 'voucher', true);
    }

    public function down()
    {
        echo "m161109_140102_alter_vouchers_add_index cannot be reverted.\n";

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
