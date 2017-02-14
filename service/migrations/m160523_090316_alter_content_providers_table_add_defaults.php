<?php

use yii\db\Migration;

class m160523_090316_alter_content_providers_table_add_defaults extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%content_providers}}', 'downloadable', $this->boolean()->notNull()->defaultValue(0));
        $this->alterColumn('{{%content_providers}}', 'streamable', $this->boolean()->notNull()->defaultValue(0));
        $this->alterColumn('{{%content_providers}}', 'storable', $this->boolean()->notNull()->defaultValue(0));
    }

    public function down()
    {
        echo "m160523_090316_alter_content_providers_table_add_defaults cannot be reverted.\n";

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
