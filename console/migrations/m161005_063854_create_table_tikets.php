<?php

use yii\db\Migration;

class m161005_063854_create_table_tikets extends Migration
{
    public function up()
    {
        $this->createTable('{{%tickets}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'ticket' => $this->string(20)->notNull(),
            'expires' => $this->integer(11)->notNull()
        ]);

        $this->createIndex('idx_tickets_tiket' , '{{%tickets}}', 'ticket', true);
        $this->addForeignKey('fk_tickets_user_id_users_id' , '{{%tickets}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        echo "m161005_063854_create_table_tikets cannot be reverted.\n";

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
