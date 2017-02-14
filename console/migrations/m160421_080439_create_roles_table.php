<?php

use yii\db\Migration;

class m160421_080439_create_roles_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%roles}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()
        ]);

        $this->insert('{{%roles}}', [
            'id' => 1,
            'name' => 'admin'
        ]);

        $this->insert('{{%roles}}', [
            'id' => 2,
            'name' => 'user'
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%roles}}');
    }
}
