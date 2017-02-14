<?php

use yii\db\Migration;

class m160410_181539_create_transaction_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'amount' => $this->double(12,2)->notNull(),
            'currency' => 'ENUM("USD","EUR") NOT NULL',
            'type' => 'ENUM("INCOMING","OUTGOING") NOT NULL',
            'timestamp' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('fk_transactions_user_id','{{%transactions}}','user_id','{{%users}}','id','CASCADE','NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%transactions}}');
    }
}
