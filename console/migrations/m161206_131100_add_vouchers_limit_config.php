<?php

use yii\db\Migration;

class m161206_131100_add_vouchers_limit_config extends Migration
{
    public function up()
    {
        $this->insert('{{%configs}}', [
            'name' => 'Reseller.UnpayedVouchersLimit',
            'value' => 2
        ]);
    }

    public function down()
    {
        echo "m161206_131100_add_vouchers_limit_config cannot be reverted.\n";

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
