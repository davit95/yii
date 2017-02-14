<?php

use yii\db\Migration;

class m160418_065707_create_links_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'link' => $this->string(200)->notNull(),
            'hash' => $this->string(60)->notNull(),
            'content_name' => $this->string(100)->notNull(),
            'content_size' => $this->integer(10)->notNull(),
            'created' => $this->integer(11)->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%links}}');
    }
}
