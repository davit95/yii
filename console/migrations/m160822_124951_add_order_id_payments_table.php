<?php

use yii\db\Migration;

class m160822_124951_add_order_id_payments_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%payments}}', 'order_id', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%payments}}', 'order_id');
    }

}
