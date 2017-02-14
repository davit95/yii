<?php

use yii\db\Migration;

class m160428_133752_alter_content_providers_add_storable_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content_providers}}', 'storable', $this->boolean()->notNull()->defaultValue(0).' AFTER streamable');
    }

    public function down()
    {
        echo "m160428_133752_alter_content_providers_add_storable_column cannot be reverted.\n";

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
