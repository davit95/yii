<?php

use yii\db\Migration;

class m160608_094843_alter_content_providers_credentials_add_unique_constraint extends Migration
{
    public function up()
    {
        $this->createIndex('idx_content_provider_id_credential_id', '{{%content_providers_credentials}}', ['content_provider_id', 'credential_id'], true);
    }

    public function down()
    {
        echo "m160608_094843_alter_content_providers_credentials_add_unique_constraint cannot be reverted.\n";

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
