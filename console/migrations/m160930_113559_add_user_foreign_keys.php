<?php

use yii\db\Migration;

class m160930_113559_add_user_foreign_keys extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_user_orders_userID','{{%user_orders}}','userID','{{%users}}','id','CASCADE','NO ACTION');
        $this->addForeignKey('fk_user_orders_product_id','{{%user_orders}}','product_id','{{%prices}}','id','CASCADE','NO ACTION');

        $this->addForeignKey('fk_payment_details_user_id','{{%payment_details}}','user_id','{{%users}}','id','CASCADE','NO ACTION');
        $this->addForeignKey('fk_payment_details_plan_id','{{%payment_details}}','plan_id','{{%prices}}','id','CASCADE','NO ACTION');

    }

    public function down()
    {
        $this->dropForeignKey('fk_user_orders_userID', "{{%user_orders}}");
        $this->dropForeignKey('fk_user_orders_product_id', "{{%user_orders}}");
        $this->dropForeignKey('fk_payment_details_user_id', "{{%payment_details}}");
        $this->dropForeignKey('fk_payment_details_plan_id', "{{%payment_details}}");
    }

}
