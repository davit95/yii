<?php

use yii\db\Migration;

class m160422_092253_alter_users_change_status_field extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%users}}', 'status', $this->boolean()->notNull()->defaultValue(true));
        $this->update('{{%users}}', ['status' => 1], 'status = 10');
    }

    public function down()
    {
        $this->alterColumn('{{%users}}', 'status', $this->smallInteger()->notNull()->defaultValue(10));
        $this->update('{{%users}}', ['status' => 10], 'status = 1');
    }
}