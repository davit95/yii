<?php

use yii\db\Migration;

class m160407_064842_create_referral_links_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%referral_links}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'type' => 'ENUM("DIRECT", "PHPBBFORUM", "IMAGE") NOT NULL',
            'template' => $this->text()->notNull(),
            'points' => $this->smallInteger()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%referral_links}}');
    }
}
