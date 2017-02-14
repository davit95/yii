<?php

use yii\db\Migration;

/**
 * Handles the creation for table `users_products_journal`.
 */
class m161123_072343_create_users_products_journal_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%users_products_journal}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'product_id' => $this->integer(11)->notNull(),
            'timestamp' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('fk_users_products_journal_user_id', '{{%users_products_journal}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('fk_users_products_journal_product_id', '{{%users_products_journal}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users_products_journal');
    }
}
