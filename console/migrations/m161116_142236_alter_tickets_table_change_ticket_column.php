<?php

use yii\db\Migration;

class m161116_142236_alter_tickets_table_change_ticket_column extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%tickets}}', 'ticket', $this->string(40)->notNull());
    }

    public function down()
    {
        echo "m161116_142236_alter_tickets_table_change_ticket_column cannot be reverted.\n";

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
