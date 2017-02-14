<?php

use yii\db\Migration;

class m161128_083323_update_homepage_text extends Migration
{
    public function up()
    {
        $homepage_data = ["Title1"=>"Download Everything With One Account","sub_title"=>"One site. One low price.{tag}{host_number} different file hosts to download from!","Title2"=>"Why Premium Link Generator","Section2Div1Title1"=>"Download from everywhere","more_than_1"=>"And more than","more_than_2" =>"{host_number} another Hosts","Section2Div1Title2"=>"All major hosters supported","Section2Div1Text"=>"Downloading files from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and other one-click -hosters? Now you can have them all with one PLG subscription!","Section2Div2Title1"=>"Download super-fast","Section2Div2Title2"=>"Utilize your max speed","Section2Div2Text"=>"Download any files you want as premium without waiting time, at a very high speed, no matter on which site the files are hosted!","Section2Div3Title1"=>"Keep your money in your pocket","Section2Div3Title2"=>"1 Account, value of {host_number} FileHosts!","Section2Div3Text"=>"Don't spend your money on various one click accounts. Downloading does not need to cost you a fortune anymore. All you need is one PLG account and you are 100% covered.","Title3"=> "When It Comes To Servers {tag} We Have The Best That Exist!","Title4"=>"So you can enjoy super-fast downloading {tag} from {host_number} different file hosts.","Title5"=>"Works very easy","EndSection"=>"That's it! {tag} Enjoy your download!"];
        $this->update('{{%pages}}', ['content'=>json_encode($homepage_data)], ['page_name' => 'homepage']);
    }

    public function down()
    {
        echo "m161128_083323_update_homepage_text cannot be reverted.\n";

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
