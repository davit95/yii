<?php

use yii\db\Migration;

class m161226_061709_add_reseller_pages extends Migration
{
    public function up()
    {
        $this->insert('{{%pages}}', ['page_name' => 'reseller-profile']);
        $this->insert('{{%pages}}', ['page_name' => 'reseller-vouchers']);
        $this->insert('{{%pages}}', ['page_name' => 'reseller-voucher']);
        $this->insert('{{%pages}}', ['page_name' => 'reseller-products']);
        $this->insert('{{%pages}}', ['page_name' => 'reseller-issue-voucher']);
        $this->insert('{{%pages}}', ['page_name' => 'reseller-pay-vouchers']);
        $this->insert('{{%pages}}', ['page_name' => 'reseller-pay-voucher']);
    }

    public function down()
    {
        echo "m161226_061709_add_reseller_pages cannot be reverted.\n";

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
