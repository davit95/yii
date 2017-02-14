<?php

use yii\db\Migration;

class m161128_141709_add_hosts_landing_page_context extends Migration
{
    public function up()
    {
        $hosts_landing_data = ["Title1"=>"Downloading from {host_name}","sub_title1"=>"Now you no longer need a Premium Account for it!","sub_title2"=>"Premium Link Generator downloads for you without captcha, without waiting and at incredible speeds","button"=>"Premium Link Generator {host_name} - Click Here","Section2Title"=>"Compare","compare_max_mb"=>"Max MB per day","download_options" =>"Download options","Pricing"=>"Pricing","EndSectionText"=>"Join Today and download EVERYTHING from EVERYWHERE {tag} {host_number} File Hosts in one Account"];
        $this->insert('{{%pages}}', [
            'page_name' => 'hosts-landing',
            'content'=>json_encode($hosts_landing_data)
        ]);
    }

    public function down()
    {
        echo "m161128_141709_add_hosts_landing_page_context cannot be reverted.\n";

        return false;
    }
}
