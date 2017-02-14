<?php

use yii\db\Migration;

class m161124_125013_rename_tables extends Migration
{
    public function up()
    {
        $this->renameTable('{{%payments}}', '_payments');
        $this->renameTable('{{%payment_details}}', '_payment_details');
        $this->renameTable('{{%prices}}', '_prices');
        $this->renameTable('{{%user_orders}}', '_user_orders');
    }

    public function down()
    {
        echo "m161124_125013_rename_tables cannot be reverted.\n";

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
