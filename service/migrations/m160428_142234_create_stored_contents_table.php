<?php

use yii\db\Migration;

class m160428_142234_create_stored_contents_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%stored_contents}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string(200)->notNull(),
            'name' => $this->string(100)->notNull(),
            'size' => $this->integer(10)->notNull(),
            'ext_url' => $this->string(200)->notNull(),
            'complete' => $this->boolean()->notNull(),
            'created' => $this->integer(11)->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%stored_contents}}');
    }
}
