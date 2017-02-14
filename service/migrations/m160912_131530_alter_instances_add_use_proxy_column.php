<?php

use yii\db\Migration;

class m160912_131530_alter_instances_add_use_proxy_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%instances}}', 'proxy_enabled', $this->boolean()->notNull()->defaultValue(0).' AFTER `storing_enabled`');
    }

    public function down()
    {
        echo "m160912_131530_alter_instances_add_use_proxy_column cannot be reverted.\n";

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
