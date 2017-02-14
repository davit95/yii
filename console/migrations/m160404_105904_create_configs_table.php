<?php

use yii\db\Migration;

class m160404_105904_create_configs_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%configs}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'value' => $this->text(),
        ], $tableOptions);

        $this->createIndex('{{%idx_config_name}}','{{%configs}}','name',true);

        $this->insert('{{%configs}}', [
            'name' => 'App.ContactEmail',
            'value' => 'contact@premiumlinkgenerator.com'
        ]);

        $this->insert('{{%configs}}', [
            'name' => 'GoogleReCaptcha.PublicKey',
            'value' => '6LcnfhwTAAAAAD-WpVbuDMycI7GlXK_9fNMXG5Bh'
        ]);

        $this->insert('{{%configs}}', [
            'name' => 'GoogleReCaptcha.SecretKey',
            'value' => '6LcnfhwTAAAAAO4bTaJLaGd07136-Ap7fFELgxYc'
        ]);

        $this->insert('{{%configs}}', [
            'name' => 'Facebook.Page',
            'value' => 'http://facebook.com'
        ]);

        $this->insert('{{%configs}}', [
            'name' => 'App.ReferralPresentationText',
            'value' => 'AllDebrid allows you to get unrestricted download speed on host\'s file without any premium subscriptions to those hosts.
            You only have to copy your links in the form, and our service will generate a link for you, which will use the full capacity of your internet connection. No more speed limitations, enjoy your downloads at full speed as it should be.
            <br/>AllDebrid also offers Firefox and Chrome extensions to generate links in 1-click, and also a JDowloader plugin to integrate our service to the famous download manager : you\'ll only have to add your links in JDownloader as usual, and the plugin will generate unrestricted links on-the-fly.<br/>
            For MegaVideo unrestrincting, our Firefox plugin allows you to watch your movies without any manipulation : it catches the player on-the-fly, and lets you choose if you want to go through our servers. When you\'ll watch a MegaVideo video, it will already be unrestricted through our services.<br/>
            Another advantage of using AllDebrid is that it will act as a proxy: our services will download the files of the hosts, not you : your IP and privacy are both protected.'
        ]);

        $this->insert('{{%configs}}', [
            'name' => 'App.ReferralPointsRate',
            'value' => 1
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%configs}}');
    }
}
