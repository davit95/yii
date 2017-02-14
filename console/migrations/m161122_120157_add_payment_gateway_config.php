<?php

use yii\db\Migration;

class m161122_120157_add_payment_gateway_config extends Migration
{
    public function up()
    {
        $this->insert('{{%configs}}', [
            'name' => 'App.PaymentGateway',
            'value' => 'frontend\components\payments\PayssionPaymentGateway'
        ]);
    }

    public function down()
    {
        echo "m161122_120157_add_payment_gateway_config cannot be reverted.\n";

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
