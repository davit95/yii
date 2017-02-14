<?php

use yii\db\Migration;

class m160921_080951_alter_referral_jornals_table extends Migration
{
    public function up()
    {
        $this->delete('{{%referral_journals}}');
        $this->dropColumn('{{%referral_journals}}', 'action');
        $this->addColumn('{{%referral_journals}}', 'action_id', $this->integer(11)->notNull().' AFTER `user_id`');
        $this->addColumn('{{%referral_journals}}', 'tracking_num', $this->string(50)->notNull().' AFTER `action_id`');

        $this->addForeignKey('fk_referral_journals_action_id_referral_actions_id', '{{%referral_journals}}', 'action_id', '{{%referral_actions}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        echo "m160921_080951_alter_referral_jornals_table cannot be reverted.\n";

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
