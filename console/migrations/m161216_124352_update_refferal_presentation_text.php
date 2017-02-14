<?php

use yii\db\Migration;

class m161216_124352_update_refferal_presentation_text extends Migration
{
    public function up()
    {
        $this->update('{{%configs}}', [
            'value' => trim('
            Premium link generator allows you to get unrestricted download speed on host\'s file without any premium subscriptions to those hosts.
            You only have to copy your links in the form, and our service will generate a link for you, which will use the full capacity of your internet connection. No more speed limitations, enjoy your downloads at full speed as it should be.
            <br/>Premium link generator also offers Firefox and Chrome extensions to generate links in 1-click, and also a JDowloader plugin to integrate our service to the famous download manager : you\'ll only have to add your links in JDownloader as usual, and the plugin will generate unrestricted links on-the-fly.<br/>
            For MegaVideo unrestrincting, our Firefox plugin allows you to watch your movies without any manipulation : it catches the player on-the-fly, and lets you choose if you want to go through our servers. When you\'ll watch a MegaVideo video, it will already be unrestricted through our services.<br/>
            Another advantage of using Premium link generator is that it will act as a proxy: our services will download the files of the hosts, not you : your IP and privacy are both protected.
            ')
        ], ['name' => 'App.ReferralPresentationText']);
    }

    public function down()
    {
        echo "m161216_124352_update_refferal_presentation_text cannot be reverted.\n";

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
