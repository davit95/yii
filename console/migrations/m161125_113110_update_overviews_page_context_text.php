<?php

use yii\db\Migration;

class m161125_113110_update_overviews_page_context_text extends Migration
{
    public function up()
    {
        $uptimepage_data = ['Title1'=>'Uptime and Overview','Title2'=>'Because transparency metters, here is a live status of hosts availability',"Text"=>'From our wild imagination... We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a "Genius Servant", "a Wiz", a "Brilliant Secretary" that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity! We knew what we wanted and how to execute it...'];
            $this->update('{{%pages}}', ['content'=>json_encode($uptimepage_data)], ['page_name' => 'uptime']);
    }

    public function down()
    {
        echo "m161125_113110_update_overviews_page_context_text cannot be reverted.\n";

        return false;
    }
}
