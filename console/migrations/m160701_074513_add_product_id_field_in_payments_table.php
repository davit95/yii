<?php

use yii\db\Migration;

class m160701_074513_add_product_id_field_in_payments_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%payments}}', 'product_id', $this->string());

    }

    public function down()
    {
        $this->dropColumn('{{%payments}}', 'product_id');
    }

}
