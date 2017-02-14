<?php

use yii\db\Migration;

class m161206_080433_alter_unrestrained_links_table_extend_column extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%unrestrained_links}}', 'content_name', $this->string(255)->notNull());
    }

    public function down()
    {
        echo "m161206_080433_alter_unrestrained_links_table_extend_column cannot be reverted.\n";

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
