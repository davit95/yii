<?php

use yii\db\Migration;

class m160921_082246_add_referral_actions extends Migration
{
    public function up()
    {
        $this->insert('{{%referral_actions}}', [
            'name' => 'visit_page',
            'description' => 'User visits page.',
            'points' => 0,
            'status' => 'ACTIVE'
        ]);

        $this->insert('{{%referral_actions}}', [
            'name' => 'register',
            'description' => 'User registers.',
            'points' => 5,
            'status' => 'ACTIVE'
        ]);

        $this->insert('{{%referral_actions}}', [
            'name' => 'buy_premium',
            'description' => 'User buys premium.',
            'points' => 10,
            'status' => 'ACTIVE'
        ]);
    }

    public function down()
    {
        echo "m160921_082246_add_referral_actions cannot be reverted.\n";

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
