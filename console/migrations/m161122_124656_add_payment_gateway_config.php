<?php

use yii\db\Migration;

class m161122_124656_add_payment_gateway_config extends Migration
{
    public function up()
    {
        $this->insert('{{%configs}}', [
            'name' => 'Payssion.SubmitUrl',
            'value' => 'http://sandbox.payssion.com/payment/create.html'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'Payssion.ReturnUrl',
            'value' => 'https://www.payssion.com/demo/afterpayment'
        ]);
    }

    public function down()
    {
        echo "m161122_124656_add_payment_gateway_config cannot be reverted.\n";

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
