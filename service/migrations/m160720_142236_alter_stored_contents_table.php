<?php

use yii\db\Migration;

class m160720_142236_alter_stored_contents_table extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%stored_contents}}', 'file');
        $this->dropColumn('{{%stored_contents}}', 'locked');
    }

    public function down()
    {
        echo "m160720_142236_alter_stored_contents_table cannot be reverted.\n";

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
