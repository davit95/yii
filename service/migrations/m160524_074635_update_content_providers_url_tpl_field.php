<?php

use yii\db\Migration;

class m160524_074635_update_content_providers_url_tpl_field extends Migration
{
    public function up()
    {
        $this->execute("UPDATE {{%content_providers}} set url_tpl = CONCAT(SUBSTRING(url_tpl,1,LENGTH(url_tpl)-1),'.+') where name in ('filespace.com', 'limefile.com', 'fboom.me', 'uplea.com', 'wwww.rarefile.net', 'rockfile.eu', 'uptobox.com', 'speedyshare.com', 'salefiles.com')");
    }

    public function down()
    {
        echo "m160524_074635_update_content_providers_url_tpl_field cannot be reverted.\n";

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
