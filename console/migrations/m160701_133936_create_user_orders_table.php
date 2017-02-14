<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_orders_table`.
 */
class m160701_133936_create_user_orders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_orders', [
            'id' => $this->primaryKey(),
            'email' => $this->string(32)->notNull(),
            'userID'=> $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'status' => $this->string()->notNull(),
            'amount'=> $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_orders');
    }
}
