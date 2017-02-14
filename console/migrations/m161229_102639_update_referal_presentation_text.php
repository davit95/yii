<?php

use yii\db\Migration;

class m161229_102639_update_referal_presentation_text extends Migration
{
    public function up()
    {
        $this->update('{{configs}}', 
            ['value' => 'You no longer have to create different accounts and pay expensive premium fees if you use Premium Link Generator. In this website, you only need to have one premium account and you will gain access to more than 60 file hosts. Included in the list are major file hosts, such as Rapidgator, Uploaded.net, Turbobit, Filepost, and much more.Downloading files, music, movies, games, and videos is easy due to its very fast speed. Moreover, there is no need to wait for files to finish downloading in the server. You can directly download everything to your computer or any device. Simply paste the link inside the box, press the “Generate PLG Link” button, and then download the file or copy it to your download accelerator. There are two downloader applications that will assist you in downloading the files: JetDownloader and JDownloader. Both of these are used to provide the best Premium Link Generator experience by providing the fastest downloading speeds. If you want proof for the performance of our service, you can check the Uptime and Overview of every host available.You can choose your plans based on the number of days that you want to use our service. All of these plans include unlimited downloads for as many files as you want and unlimited traffic. If ever you are not satisfied with our service, you can get your full payment with our money-back guarantee.'
        ], ['name' => 'App.ReferralPresentationText']);
    }

    public function down()
    {
        $this->update('{{configs}}', 
        ['value' => "Premium link generator allows you to get unrestricted download speed on host's file without any premium subscriptions to those hosts.You only have to copy your links in the form, and our service will generate a link for you, which will use the full capacity of your internet connection. No more speed limitations, enjoy your downloads at full speed as it should be.<br/>Premium link generator also offers Firefox and Chrome extensions to generate links in 1-click, and also a JDowloader plugin to integrate our service to the famous download manager : you'll only have to add your links in JDownloader as usual, and the plugin will generate unrestricted links on-the-fly.<br/>For MegaVideo unrestrincting, our Firefox plugin allows you to watch your movies without any manipulation : it catches the player on-the-fly, and lets you choose if you want to go through our servers. When you'll watch a MegaVideo video, it will already be unrestricted through our services.<br/>Another advantage of using Premium link generator is that it will act as a proxy: our services will download the files of the hosts, not you : your IP and privacy are both protected."
        ], ['name' => 'App.ReferralPresentationText']);
    }

}
