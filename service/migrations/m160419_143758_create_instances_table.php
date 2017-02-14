<?php

use yii\db\Migration;

class m160419_143758_create_instances_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%instances}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string(10)->notNull(),
            'name' => $this->string(100)->notNull(),
            'status' => 'ENUM("ACTIVE","INACTIVE") NOT NULL'
        ]);

        $this->createIndex('idx_instances_uid', '{{%instances}}', 'uid', true);

        $this->insert('{{%instances}}', [
            'uid' => 'gXP9B9qd4Y',
            'name' => 'plg.svc.01',
            'status' => 'ACTIVE'
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%instances}}');
    }
}
