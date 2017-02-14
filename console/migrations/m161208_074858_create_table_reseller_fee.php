<?php

use yii\db\Migration;

class m161208_074858_create_table_reseller_fee extends Migration
{
    public function up()
    {
        $this->createTable('{{%resellers_fees}}', [
            'id' => $this->primaryKey(),
            'percent' => $this->decimal(5, 2)->notNull()->defaultValue(0),
            'amount' => $this->decimal(5, 2)->notNull()->defaultValue(0),
            'user_id' => $this->integer(11)->notNull(),
            'status' => 'ENUM("ACTIVE", "INACTIVE") NOT NULL',
            'created' => $this->integer(11)->notNull(),
            'updated' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('fk_resellers_fee_user_id', '{{%resellers_fees}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        echo "m161208_074858_create_table_reseller_fee cannot be reverted.\n";

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
