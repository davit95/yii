<?php

use yii\db\Migration;

class m160525_072925_update_content_providers_url_tpl_field extends Migration
{
    public function up()
    {
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/filespace\.com\/.+'], ['name' => 'filespace.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/(www.)?limefile\.com\/.+'], ['name' => 'limefile.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/fboom\.me\/.+'], ['name' => 'fboom.me']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/uplea\.com\/.+'], ['name' => 'uplea.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/uptobox\.com\/.+'], ['name' => 'uptobox.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/www\.rarefile\.net\/.+'], ['name' => 'wwww.rarefile.net']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/rockfile\.eu\/.+'], ['name' => 'rockfile.eu']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/www.speedyshare\.com\/.+'], ['name' => 'speedyshare.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/salefiles\.com\/.+'], ['name' => 'salefiles.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http(s)?:\/\/subyshare\.com\/.+'], ['name' => 'subyshare.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/www\.doraupload\.com\/.+'], ['name' => 'doraupload.com']);
        $this->update('{{%content_providers}}', ['url_tpl' => 'http:\/\/upload\.cd\/.+'], ['name' => 'upload.cd']);
    }

    public function down()
    {
        echo "m160525_072925_update_content_providers_url_tpl_field cannot be reverted.\n";

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
