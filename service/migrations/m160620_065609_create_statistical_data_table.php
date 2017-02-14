<?php

use yii\db\Migration;

/**
 * Handles the creation for table `statistical_data_table`.
 */
class m160620_065609_create_statistical_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%statistical_data}}', [
            'id' => $this->primaryKey(),
            'statistical_data_set_id' => $this->integer(11)->notNull(),
            'attr_1_val' => $this->string(100),
            'attr_2_val' => $this->string(100),
            'attr_3_val' => $this->string(100),
            'attr_4_val' => $this->string(100),
            'attr_5_val' => $this->string(100),
            'timestamp' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('fk_statistical_data_statistical_data_set_id', '{{%statistical_data}}', 'statistical_data_set_id', '{{%statistical_data_sets}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%statistical_data}}');
    }
}
