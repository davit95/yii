<?php

use yii\db\Migration;

class m160418_090021_create_content_providers_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%content_providers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'class' => $this->string(100)->notNull(),
            'url_tpl' => $this->string(200)->notNull(),
            'auth_url' => $this->string(200),
            'downloadable' => $this->boolean()->notNull()->defaultValue(0),
            'streamable' => $this->boolean()->notNull()->defaultValue(0),
            'status' => 'ENUM("ACTIVE","INACTIVE") NOT NULL'
        ]);

        $this->insert('{{%content_providers}}', [
            'name' => 'Base content',
            'class' => 'service\\components\\BaseContent',
            'url_tpl' => '.*',
            'auth_url' => null,
            'downloadable' => 1,
            'streamable' => 1,
            'status' => 'INACTIVE'
        ]);

        $this->insert('{{%content_providers}}', [
            'name' => '1fichier.com',
            'class' => 'service\\components\\OneFichierCom',
            'url_tpl' => 'https?:\/\/1fichier\.com\/.+',
            'auth_url' => 'https://1fichier.com/login.pl',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%content_providers}}');
    }
}
