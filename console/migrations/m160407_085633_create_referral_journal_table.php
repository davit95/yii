<?php

use yii\db\Migration;

class m160407_085633_create_referral_journal_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%referral_journals}}', [
            'id' => $this->primaryKey(),
            'referral_link_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'action' => 'ENUM("VISIT","BUY_PREMIUM") NOT NULL',
            'timestamp' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('fk_referral_journals_user_id','{{%referral_journals}}','user_id','{{%users}}','id','CASCADE','NO ACTION');
        $this->addForeignKey('fk_referral_journals_referral_link_id','{{%referral_journals}}','referral_link_id','{{%referral_links}}','id','CASCADE','NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%referral_journals}}');
    }
}
