<?php

use yii\db\Migration;

class m160916_125203_alter_content_providers_table_rename_updated_at_column extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%content_providers}}', 'updated_at', 'updated');
    }

    public function down()
    {
        echo "m160916_125203_alter_content_providers_table_rename_updated_at_column cannot be reverted.\n";

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
