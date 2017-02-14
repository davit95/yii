<?php

use yii\db\Migration;

class m160929_153134_alter_table_transactions_add_period_and_limit_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%transactions}}', 'limit', $this->integer());
        $this->addColumn('{{%transactions}}', 'period', $this->integer());
        $this->addColumn('{{%transactions}}', 'payment_status', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%transactions}}', 'limit');
        $this->dropColumn('{{%transactions}}', 'period');
        $this->dropColumn('{{%transactions}}', 'payment_status');
    }

}
