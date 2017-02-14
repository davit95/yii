<?php

use yii\db\Migration;

class m161128_115142_update_payments_config extends Migration
{
    public function up()
    {
        $this->delete('{{%configs}}', ['name' => 'App.PaymentGateway']);
        $this->insert('{{%configs}}', [
            'name' => 'Gourl.PublicKey',
            'value' => '7312AAoChfaBitcoin77BTCPUBkNT8icPZ9NZTjE8go2l4hw2b'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'Gourl.PrivateKey',
            'value' => '7312AAoChfaBitcoin77BTCPRVPJNd8aHszLvcrpfcZMb5UaRs'
        ]);
    }

    public function down()
    {
        echo "m161128_115142_update_payments_config cannot be reverted.\n";

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
