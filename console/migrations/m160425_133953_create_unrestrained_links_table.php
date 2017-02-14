<?php

use yii\db\Migration;

class m160425_133953_create_unrestrained_links_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%unrestrained_links}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'download_link' => $this->string(200),
            'stream_link' => $this->string(200),
            'content_name' => $this->string(100)->notNull(),
            'content_size' => $this->integer(10)->notNull(),
            'created' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('fk_unrestrained_links_user_id', '{{%unrestrained_links}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%unrestrained_links}}');
    }
}
