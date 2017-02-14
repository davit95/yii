<?php

use yii\db\Migration;

class m161206_093747_alter_vaouchers_table_add_is_payed_col extends Migration
{
    public function up()
    {
        $this->addColumn('{{%vouchers}}', 'is_payed', $this->boolean()->notNull()->defaultValue(0).' AFTER `user_id`');
    }

    public function down()
    {
        echo "m161206_093747_alter_vaouchers_table_add_is_payed_col cannot be reverted.\n";

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
