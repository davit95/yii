<?php

use yii\db\Migration;

class m161129_123104_add_config_options_for_curopayments_gateway extends Migration
{
    public function up()
    {
        $this->insert('{{%configs}}', [
            'name' => 'Curopayments.SiteId',
            'value' => '1'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'Curopayments.HashKey',
            'value' => 'TESTHASH'
        ]);
        $this->insert('{{%configs}}', [
            'name' => 'Curopayments.SubmitUrl',
            'value' => 'https://secure-staging.curopayments.net/gateway/'
        ]);
    }

    public function down()
    {
        echo "m161129_123104_add_config_options_for_curopayments_gateway cannot be reverted.\n";

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
