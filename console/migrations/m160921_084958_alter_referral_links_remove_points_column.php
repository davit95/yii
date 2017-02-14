<?php

use yii\db\Migration;

class m160921_084958_alter_referral_links_remove_points_column extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%referral_links}}', 'points');
    }

    public function down()
    {
        echo "m160921_084958_alter_referral_links_remove_points_column cannot be reverted.\n";

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
