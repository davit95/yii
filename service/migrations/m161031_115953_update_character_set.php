<?php

use yii\db\Migration;

class m161031_115953_update_character_set extends Migration
{
    public function up()
    {
        $dbName = Yii::$app->db->createCommand('SELECT DATABASE()')->queryScalar();
        $this->execute("ALTER DATABASE $dbName CHARACTER SET utf8 COLLATE utf8_unicode_ci");
        $this->execute('ALTER TABLE content_providers CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE content_providers_credentials CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE credentials CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE links CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE logs CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE migration CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE statistical_data CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE statistical_data_sets CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE statistical_indexes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE stored_content_chunks CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE stored_contents CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->execute('ALTER TABLE instances CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {
        echo "m161031_115953_update_character_set cannot be reverted.\n";

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
