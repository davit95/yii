<?php

use yii\db\Migration;

class m161212_103348_update_gourl_config_values extends Migration
{
    public function up()
    {
        $this->update('{{%configs}}', ['value' => '7570AAAQBcsBitcoin77BTCPUByA933UxhRtvIaJpbeH0fJcRM'], ['name' => 'Gourl.PublicKey']);
        $this->update('{{%configs}}', ['value' => '7570AAAQBcsBitcoin77BTCPRV8zwZ8yapm72gMZvvm3oOzzIm'], ['name' => 'Gourl.PrivateKey']);
    }

    public function down()
    {
        echo "m161212_103348_update_gourl_config_values cannot be reverted.\n";

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
