<?php

use yii\db\Migration;

class m160621_082840_alter_stored_contents_table_add_defaults extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%stored_contents}}','complete', $this->boolean()->notNull()->defaultValue(0));
    }

    public function down()
    {
        echo "m160621_082840_alter_stored_contents_table_add_defaults cannot be reverted.\n";

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
