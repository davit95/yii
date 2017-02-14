<?php

use yii\db\Migration;

class m161017_064227_add_address_config_item extends Migration
{
    public function up()
    {
        $this->insert('{{%configs}}', [
            'name' => 'App.AddressCompanyName',
            'value' => 'PLG'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'App.AddressCity',
            'value' => 'City'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'App.AddressStreet',
            'value' => 'PLG'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'App.AddressPhone',
            'value' => '+380123456789'
        ]);
    }

    public function down()
    {
        echo "m161017_064227_add_address_config_item cannot be reverted.\n";

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
