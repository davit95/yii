<?php

use yii\db\Migration;

class m160801_123042_alter_stored_content_chunks_table_add_locked_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%stored_content_chunks}}', 'locked', $this->boolean()->notNull()->defaultValue(0).' AFTER `length`');
    }

    public function down()
    {
        echo "m160801_123042_alter_stored_content_chunks_table_add_locked_column cannot be reverted.\n";

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
