<?php

use yii\db\Migration;

class m160609_135842_add_column_payments_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%payments}}', 'payment_token', $this->string(64));
    }

    public function down()
    {
        $this->dropColumn('{{%prices}}', 'payment_token');
    }
}
