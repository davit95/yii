<?php

use yii\db\Migration;

class m161202_091207_remove_unnecessary_objects_and_columns extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_users_role_id', '{{%users}}');
        $this->dropColumn('{{%users}}', 'role_id');
        $this->dropTable('{{%roles}}');
    }

    public function down()
    {
        echo "m161202_091207_remove_unnecessary_objects_and_columns cannot be reverted.\n";

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
