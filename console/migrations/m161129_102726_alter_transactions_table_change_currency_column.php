<?php

use yii\db\Migration;

class m161129_102726_alter_transactions_table_change_currency_column extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%transactions}}', 'currency', 'ENUM("USD", "EUR", "BTC") NOT NULL');
    }

    public function down()
    {
        echo "m161129_102726_alter_transactions_table_change_currency_column cannot be reverted.\n";

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
