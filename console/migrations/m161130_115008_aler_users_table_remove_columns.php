<?php

use yii\db\Migration;

class m161130_115008_aler_users_table_remove_columns extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_users_price_id', '{{%users}}');
        $this->dropColumn('{{%users}}', 'price_id');
        $this->dropColumn('{{%users}}', 'start_date');
        $this->dropColumn('{{%users}}', 'period');
        $this->dropColumn('{{%users}}', 'limit');
        $this->dropColumn('{{%users}}', 'plan_status');
    }

    public function down()
    {
        echo "m161130_115008_aler_users_table_remove_columns cannot be reverted.\n";

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
