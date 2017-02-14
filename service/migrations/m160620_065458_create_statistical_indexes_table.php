<?php

use yii\db\Migration;

/**
 * Handles the creation for table `statistical_indexes_table`.
 */
class m160620_065458_create_statistical_indexes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%statistical_indexes}}', [
            'id' => $this->primaryKey(),
            'statistical_data_set_id' => $this->integer(11)->notNull(),
            'name' => $this->string(100)->notNull(),
            'attributes' => $this->string(500)->notNull(),
            'description' => $this->string(500)->notNull()
        ]);

        $this->createIndex('idx_statistical_index_name', '{{%statistical_indexes}}', ['name'], true);
        $this->addForeignKey('fk_statistical_indexes_statistical_data_set_id', '{{%statistical_indexes}}', 'statistical_data_set_id', '{{%statistical_data_sets}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%statistical_indexes}}');
    }
}
