<?php

use yii\db\Migration;

/**
 * Handles the creation for table `products`.
 */
class m161121_104052_create_products_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->string(500)->notNull(),
            'type' => 'ENUM("LIMITED", "DAILY") NOT NULL',
            'limit' => $this->integer(11)->defaultValue(null),
            'days' => $this->integer(11)->notNull()->defaultValue(null),
            'status' => 'ENUM("ACTIVE", "INACTIVE") NOT NULL',
            'created' => $this->integer(11)->notNull(),
            'updated' => $this->integer(11)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products');
    }
}
