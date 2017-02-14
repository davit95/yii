<?php

use yii\db\Migration;

/**
 * Handles the creation for table `statistical_data_sets`.
 */
class m160619_070052_create_table_statistical_data_sets extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%statistical_data_sets}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'attributes' => $this->string(500)->notNull(),
            'description' => $this->string(500)->notNull()
        ]);

        $this->createIndex('idx_statistical_data_sets_name', '{{%statistical_data_sets}}', ['name'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%statistical_data_sets}}');
    }
}
