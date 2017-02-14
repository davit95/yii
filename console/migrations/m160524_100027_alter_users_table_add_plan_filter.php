<?php

use yii\db\Migration;

class m160524_100027_alter_users_table_add_plan_filter extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'price_id', $this->integer(11));
        $this->addForeignKey('fk_users_price_id', '{{%users}}', 'price_id', '{{%prices}}', 'id', 'SET NULL');

    }

    public function down()
    {
        $this->dropForeignKey('fk_users_price_id', "{{%users}}");
        $this->dropColumn('{{%users}}', 'price_id');
    }
}
