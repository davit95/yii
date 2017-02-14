<?php

use yii\db\Migration;

class m161121_083836_add_payssion_gateway_configuration extends Migration
{
    public function up()
    {
        $this->insert('{{%configs}}', [
            'name' => 'Payssion.ApiKey',
            'value' => '405004ad74abd7aa'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'Payssion.ApiSecret',
            'value' => '0dfe63294feb95036dde876109d60360'
        ]);
    }

    public function down()
    {
        echo "m161121_083836_add_payssion_gateway_configuration cannot be reverted.\n";

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
