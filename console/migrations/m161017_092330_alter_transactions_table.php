<?php

use yii\db\Migration;

class m161017_092330_alter_transactions_table extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%transactions}}', 'limit');
        $this->dropColumn('{{%transactions}}', 'period');
        $this->dropColumn('{{%transactions}}', 'payment_status');

        $this->addColumn('{{%transactions}}', 'data', $this->text()->defaultValue(null).' AFTER `type`');
    }

    public function down()
    {
        echo "m161017_092330_alter_transactions_table cannot be reverted.\n";

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
