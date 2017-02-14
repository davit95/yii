<?php

use yii\db\Migration;

class m160427_141155_create_payments_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'transaction_id' => $this->string(),
            'state'  => $this->string(),
            'amount' => $this->double(),
            'currency' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],'ENGINE=InnoDB');
        $this->addForeignKey('fk_payments_user_id', '{{%payments}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_payments_user_id',"{{%payments}}");
        $this->dropTable('{{%payments}}');
    }
}
