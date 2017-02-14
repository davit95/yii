<?php

use yii\db\Migration;

class m161205_115726_alter_unrestrained_links_table_chenge_content_name_col extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%unrestrained_links}}', 'content_name', $this->string(1000)->notNull());
    }

    public function down()
    {
        echo "m161205_115726_alter_unrestrained_links_table_chenge_content_name_col cannot be reverted.\n";

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
