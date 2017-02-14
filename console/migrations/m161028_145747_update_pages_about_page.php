<?php

use yii\db\Migration;

class m161028_145747_update_pages_about_page extends Migration
{
    public function up()
    {
        $aboutuspage_data = ["Title1"=>"About us","Section1Text"=>"<h6 class='tx-lblue'>It all started from our wild imagination… </h6><div class='tx-white thin'>We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a 'Genius Servant' that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity!</div>","Section2div1"=>"<h5 class=''>Our vision</h5><div class='thin'>Was to change the way people work, store and download! We basically wanted to create a service that is user friendly, inexpensive and smart. In other words: we tried to reinvent, redefine and upgrade the whole experience you, the user, have with clouds. We wanted to give the user the Benefit of Simplicity: to access all their clouds with one Account!</div>","Section2div2"=>"<h5 class=''>Our staff</h5><div class='thin'>s a very committed group of highly qualified specialists in the field of programming, web-design and marketing. All of them share the same values of building advanced software that will make people’s lives easier. Our main principle is simply to create great software, satisfying the needs of the Internet users.</div>","Title2"=>"Still have a question? Feel free to contact us!" ];
        $this->update('{{%pages}}', ['content'=>json_encode($aboutuspage_data)], ['page_name' => 'about']);
    }

    public function down()
    {
        echo "m161028_145747_update_pages_about_page cannot be reverted.\n";

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
