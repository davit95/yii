<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `new_pages_table`.
 */
class m160712_162556_create_new_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'page_name'=> Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ]);
        $homepage_data = ["Title1"=>"Download Everything With One Account","Title2"=>"Why Premium Link Generator","Section2div1"=>"<h6 class='thin'>Download from everywhere</h6><h6>All major hosters supported</h6><p class='thin'>Downloading files from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and other one-click -hosters? Now you can have them all with one PLG subscription!</p>","Section2div2"=>"<h6 class='thin'>Download super-fast</h6><h6>Utilize your max speed</h6><p class='thin'>Download any files you want as premium without waiting time, at a very high speed, no matter on which site the files are hosted!</p>","Section2div3"=>"<h6 class='thin'>Keep your money in your pocket</h6><h6>1 Account, value of 118 FileHosts!</h6><p class='thin'>Donâ€™t spend your money on various one click accounts. Downloading does not need to cost you a fortune anymore. All you need is one PLG account and you are 100% covered.</p>","Title3"=> "<h2 class='tx-white lthin'>When It Comes To Servers<br>We Have The Best That Exist!</h2>","Title4"=>"Works very easy","EndSection4"=>" <h4 class='tx-lblue'>That's it! <br> Enjoy your download! </h4>"];
        $this->insert('{{%pages}}', [
            'page_name' => 'homepage',
            'content'=>json_encode($homepage_data)
        ]);

        $workpage_data = ["Title1"=>"How it works","Section1Text"=>"<h5 class='tx-lblue'>Forget about downloading delays. No need to wait until the files are downloaded to Zevera’s servers and<br> then to your device, neither. Just add the links of any supported hoster, and downloading starts<br> immediately!</h5>","Section2Text"=>" <h5 class='b'>In order to make your life even more easy, we work with the best Downloader Applications.</h5><div class='thin'>The Downloader Applications below optimize your Zevera experience by providing better speeds.<br>
        Chose the one you prefer, customize the Settings and enjoy optimum Zevera downloading.</div>","Section3Text"=>"Jet Downloader is a program designed to help you to download content on multiple file hosters and efficiently manage your bandwidth. After you configure your file hosting accounts in the software, you can easily download any content. Jet Downloader supports multi-segments download: it means it downloads multiple parts of your files at the same time and then join them together. It allows you to have better download speed with no inconveniences.","Section4Text"=>"JDownloader is a free, open-source download management tool with a huge community of developers that makes downloading as easy and fast as it should be. Users can start, stop or pause downloads, set bandwith limitations, auto-extract archives and much more. It's an easy-to-extend framework that can save hours of your valuable time every day!"];
        $this->insert('{{%pages}}', [
            'page_name' => 'work',
            'content'=>json_encode($workpage_data)
        ]);

        $hostpage_data = ["Title1"=>"Supported File Hosts","Section1Text"=>"The list below is our whole pride! The zevera.com supported hosters- brought to you all with the price of one premium account! You are literally a few steps away from downloading as premium from all of the below supported one click hosters! And of course we are constantly adding new hosters once they become popular. As a matter of fact if you have a special hoster request please don’t hesitate to let us know!"];
        $this->insert('{{%pages}}', [
            'page_name' => 'hosts',
            'content'=>json_encode($hostpage_data)
        ]);

        $uptimepage_data = ["Title1"=>"
            From our wild imaginationâ€¦ We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a â€œGenius Servantâ€, â€œa Wizâ€, a â€œBrilliant Secretaryâ€ that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity! We knew what we wanted and how to execute it..."];
        $this->insert('{{%pages}}', [
            'page_name' => 'uptime',
            'content'=>json_encode($uptimepage_data)
        ]);

        $pricingpage_data = ["Title1"=>"Why Upgrade Account","Section1div1"=>"<h5 class='tx-white'>Premium Downloading <br>from 120 File-Hosters</h5><div class='tx-lblue'>No other site supports so many File Hosts! Download from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and so many more with the price of one!</div>","Section1div2"=>"<h5 class='tx-white'>No daily limits on<br> Download</h5><div class='tx-lblue'>Download as much as you want ignoring form which file hoster it is, without worrying about daily limits and while saving money at the same time!</div>","Section1div3"=>"<h5 class='tx-white'>Unlimited parallel<br> Downloads</h5><div class='tx-lblue'>Our Premium users can download as many files as they want at the same time!</div>","Section1div4"=>"<h5 class='tx-white'>Money-back<br> Guarantee</h5><div class='tx-lblue'>In the rare case you stay unsatisfied by our services Premium Link Generator offers you a full- money- back guarantee!</div>","Title2"=>"Choose Your Plan","Section3Text"=>"<h4 class='tx-white lthin'>Not a fan of subscriptions?<br>Choose the gigabytes package that suits you best without expiry date!</h4>","Title3"=>"Try 7 Free-trial days","Section4Text"=>"<div>We offer you 7 free-trial days when registered to help you form your opinion about our services.</div><div class='liter thin'><small>This offer is restricted to new members only <br>10 Gb download limit per day</small></div>","Title4"=>"We Accept","Section5div1"=>"<h5 class='tx-blue'>100% Security Guarantee</h5><div class='thin'>All your payments are carried out via<br> very reliable third-party companies</div>","Section5div2"=>"<h5 class='tx-blue'>Safety is out Nr1 Priority</h5><div class='thin'>All transactions are carried out in an<br> absolutely safe environment</div>","Section5div3"=>"<h5 class='tx-blue'>Anonymity is guaranteed    </h5><div class='thin'>All your data stays unknown!<br> Nobody will ever know your<br> payment details</div>"];
        $this->insert('{{%pages}}', [
            'page_name' => 'price',
            'content'=>json_encode($pricingpage_data)
        ]);

        $aboutuspage_data = ["Title1"=>"About us","Section1Text"=>"<h6 class='x-lblue'>It all started from our wild imagination… </h6><div class='tx-white thin'>We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a 'Genius Servant' that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity!</div>","Section2div1"=>"<h5 class=''>Our vision</h5><div class='thin'>Was to change the way people work, store and download! We basically wanted to create a service that is user friendly, inexpensive and smart. In other words: we tried to reinvent, redefine and upgrade the whole experience you, the user, have with clouds. We wanted to give the user the Benefit of Simplicity: to access all their clouds with one Account!</div>","Section2div2"=>"<h5 class=''>Our staff</h5><div class='thin'>s a very committed group of highly qualified specialists in the field of programming, web-design and marketing. All of them share the same values of building advanced software that will make people’s lives easier. Our main principle is simply to create great software, satisfying the needs of the Internet users.</div>","Title2"=>"Still have a question? Feel free to contact us!" ];
        $this->insert('{{%pages}}', [
            'page_name' => 'about',
            'content'=>json_encode($aboutuspage_data),
        ]);

        $contactuspage_data = ["Text"=>" <h2>Contact Us</h2><h5>Values we stand for</h5><div class='b'>Real and secure privacy</div><p class='thin'>Are you often out, surfing in cafes, railway stations or airports? Thats an invitation for data thieves. Save your networks, your identity, bank and credit card data. All Internet connections are encrypted using up to 256-bit - so no one will get your data.</p><br><div class='b'>Absolutely reliable</div><p class='thin'>We don’t know cheapy, just low cost for value! While selecting our infrastructure, we look for the highest quality you can get in our worldwide server - network. Access to all sites is well protected against unauthorized access</p><br><div class='b'>Full cost control</div><p class='thin'>No ongoing subscription, with us you only pay for the product you chose. Risk free and absolutely transparent.</p><br>"];
        $this->insert('{{%pages}}', [
            'page_name' => 'contact',
            'content'=>json_encode($contactuspage_data),
        ]);

        $termspage_data = ["Title"=>"Terms of use","Text"=>"<div class='b'>Requirements to use the service</div><p class='thin'>We offer a service for individuals able to agree on a contract with us. The user must abide by the rules of this website.</p><br><div class='b'>Services</div><p class='thin'>We agree to offer several services to the user. We keep the right to change or shut down our services at any time without any explanations, or to reduce it's traffic at our willingness. A purchase on AllDebrid grants you access to a private part of the website, by consequence, changes or deletions on these pages can occure at any time without advance notice.</p><br><div class='b'>Personal informations</div><p class='thin'>The user certifies that the informations provided are complete, up-to-date, true and accurate. The user commits to edit his information if they change in the future. The user certifies that the informations provided are complete, up-to-date, true and accurate. The user commits to edit his information if they change in the future. The user certifies that the informations provided are complete, up-to-date, true and accurate. The user commits to edit his information if they change in the future.  </p><div class='b'>Requirements to use the service</div><p class='thin'>We offer a service for individuals able to agree on a contract with us. The user must abide by the rules of this website. </p><br><div class='b'>Services</div><p class='thin'>We agree to offer several services to the user. We keep the right to change or shut down our services at any time without any explanations, or to reduce it's traffic at our willingness. A purchase on AllDebrid grants you access to a private part of the website, by consequence, changes or deletions on these pages can occure at any time without advance notice.</p><br><div class='b'>Personal informations</div><p class='thin'>The user certifies that the informations provided are complete, up-to-date, true and accurate. The user commits to edit his information if they change in the future. The user certifies that the informations provided are complete, up-to-date, true and accurate. The user commits to edit his information if they change in the future. The user certifies that the informations provided are complete, up-to-date, true and accurate. The user commits to edit his information if they change in the future. </p>"];
        $this->insert('{{%pages}}', [
            'page_name' => 'terms',
            'content'=>json_encode($termspage_data),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%pages}}');
    }
}
