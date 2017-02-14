<?php

use yii\db\Migration;

/**
 * Handles the creation for table `orders`.
 */
class m161121_100134_create_orders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'cost' => $this->decimal(12, 2)->notNull(),
            'currency' => $this->string(3)->notNull(),
            'description' => $this->string(255)->notNull(),
            'status' => 'ENUM("COMPLETED", "PENDING", "SUSPENDED") NOT NULL'
        ]);

        $this->addForeignKey('fk_orders_user_id', '{{%orders}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('orders');
    }
}
