<?php

use yii\db\Migration;

class m160912_125246_alter_content_providers_add_use_proxy_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content_providers}}', 'use_proxy', $this->boolean()->notNull()->defaultValue(0).' AFTER `storable`');
    }

    public function down()
    {
        echo "m160912_125246_alter_content_providers_add_use_proxy_column cannot be reverted.\n";

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
