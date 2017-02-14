<?php

use yii\db\Migration;

class m160621_084455_alter_stored_contents_table_add_locked_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%stored_contents}}', 'locked', $this->boolean()->notNull()->defaultValue(0).' AFTER ext_url');
    }

    public function down()
    {
        echo "m160621_084455_alter_stored_contents_table_add_locked_column cannot be reverted.\n";

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
