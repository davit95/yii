<?php

use yii\db\Migration;

/**
 * Handles the creation for table `stored_content_chunks`.
 */
class m160718_125510_create_stored_content_chunks_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%stored_content_chunks}}', [
            'id' => $this->primaryKey(),
            'stored_content_id' => $this->integer(11)->notNull(),
            'file' => $this->string(200)->notNull(),
            'start' => $this->integer(11)->notNull(),
            'end' => $this->integer(11)->notNull(),
            'length' => $this->integer(11)->notNull(),
            'created' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('fk_stored_content_chunks_stored_content_id', '{{%stored_content_chunks}}', 'stored_content_id', '{{%stored_contents}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%stored_content_chunks}}');
    }
}
