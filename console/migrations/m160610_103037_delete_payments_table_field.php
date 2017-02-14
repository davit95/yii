<?php

use yii\db\Migration;

class m160610_103037_delete_payments_table_field extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%payments}}', 'payment_token');
    }

    public function down()
    {
        $this->addColumn('{{%payments}}', 'payment_token', $this->string(64));
    }

}
