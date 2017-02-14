<?php

use yii\db\Migration;

class m160930_090335_alter_instances_table_add_app_api_url_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%instances}}', 'app_api_url', $this->string(200)->notNull().' AFTER `proxy_enabled`');
    }

    public function down()
    {
        echo "m160930_090335_alter_instances_table_add_app_api_url_column cannot be reverted.\n";

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
