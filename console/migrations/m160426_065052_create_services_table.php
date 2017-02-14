<?php

use yii\db\Migration;

class m160426_065052_create_services_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%services}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string(10)->notNull(),
            'url' => $this->string(200)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%services}}');
    }
}
