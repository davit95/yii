<?php

use yii\db\Migration;

class m161111_104609_alter_links_table_add_unique_index extends Migration
{
    public function up()
    {
        $this->createIndex('idx_links_hash', '{{%links}}', 'hash', true);
    }

    public function down()
    {
        echo "m161111_104609_alter_links_table_add_unique_index cannot be reverted.\n";

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
