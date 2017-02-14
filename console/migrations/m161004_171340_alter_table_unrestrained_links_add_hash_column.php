<?php

use yii\db\Migration;
use yii\db\Query;

class m161004_171340_alter_table_unrestrained_links_add_hash_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%unrestrained_links}}', 'hash', $this->string(60)->notNull().' AFTER `user_id`');

        $query = new Query();
        $query->from('{{%unrestrained_links}}');

        foreach ($query->each() as $row) {
            $hash = sha1($row['user_id'].$row['content_name'].$row['content_size'].$row['created']);
            $this->update('{{%unrestrained_links}}', ['hash' => $hash], ['id' => $row['id']]);
        }
    }

    public function down()
    {
        echo "m161004_171340_alter_table_unrestrained_links_add_hash_column cannot be reverted.\n";

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
