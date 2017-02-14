<?php

use yii\db\Migration;

class m160927_155607_alter_user_orders_table_add_order_id_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user_orders}}', 'order_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%user_orders}}', 'order_id');
    }

}
