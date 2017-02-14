<?php

use yii\db\Migration;

class m161115_074732_create_table_download_journal extends Migration
{
    public function up()
    {
        $this->createTable('{{%download_journals}}', [
            'id' => $this->primaryKey(),
            'service_uid' => $this->string(10)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'provider' => $this->string(100)->notNull(),
            'bytes_sent' => $this->integer(11)->notNull(),
            'timestamp' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('fk_download_journals_user_id', '{{%download_journals}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        echo "m161115_074732_create_table_download_journal cannot be reverted.\n";

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
