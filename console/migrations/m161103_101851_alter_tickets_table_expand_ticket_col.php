<?php

use yii\db\Migration;

class m161103_101851_alter_tickets_table_expand_ticket_col extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%tickets}}', 'ticket', $this->string(255)->notNull());
    }

    public function down()
    {
        echo "m161103_101851_alter_tickets_table_expand_ticket_col cannot be reverted.\n";

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
