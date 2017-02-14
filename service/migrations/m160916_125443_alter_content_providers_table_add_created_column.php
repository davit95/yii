<?php

use yii\db\Migration;

class m160916_125443_alter_content_providers_table_add_created_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content_providers}}', 'created', $this->integer().' AFTER `status`');
        $this->update('{{%content_providers}}', ['created' => time()]);
        $this->alterColumn('{{%content_providers}}', 'created', $this->integer()->notNull().' AFTER `status`');
    }

    public function down()
    {
        echo "m160916_125443_alter_content_providers_table_add_created_column cannot be reverted.\n";

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
