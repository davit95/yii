<?php

use yii\db\Migration;
use yii\db\Query;

class m161111_114543_alter_unrestrained_links_table_add_unique_index extends Migration
{
    public function up()
    {
        $query = new Query();
        $query->select('`a`.`id`');
        $query->from('{{%unrestrained_links}} a, {{%unrestrained_links}} b');
        $query->where('`a`.`id` <> `b`.`id`');
        $query->andWhere('`a`.`hash` = `b`.`hash`');

        foreach ($query->each() as $id) {
            $this->update('{{%unrestrained_links}}', ['hash' => sha1(uniqid('', true))], ['id' => $id]);
        }

        $this->createIndex('idx_unrestrained_links_hash', '{{%unrestrained_links}}', 'hash', true);
    }

    public function down()
    {
        echo "m161111_114543_alter_unrestrained_links_table_add_unique_index cannot be reverted.\n";

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
