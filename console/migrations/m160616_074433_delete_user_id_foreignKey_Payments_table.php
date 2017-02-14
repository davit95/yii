<?php

use yii\db\Migration;

class m160616_074433_delete_user_id_foreignKey_Payments_table extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_payments_user_id',"{{%payments}}");
    }

    public function down()
    {
        $this->addForeignKey('fk_payments_user_id', '{{%payments}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
    }
}
