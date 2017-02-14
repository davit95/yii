<?php

use yii\db\Migration;

class m161028_150611_update_pages_contact_page extends Migration
{
    public function up()
    {
        $contactuspage_data = ["Text"=>" <h2 class='thin'>Contact Us</h2><h5>Values we stand for</h5><div class='b'>Real and secure privacy</div><p class='thin'>Are you often out, surfing in cafes, railway stations or airports? Thats an invitation for data thieves. Save your networks, your identity, bank and credit card data. All Internet connections are encrypted using up to 256-bit - so no one will get your data.</p><br><div class='b'>Absolutely reliable</div><p class='thin'>We don’t know cheapy, just low cost for value! While selecting our infrastructure, we look for the highest quality you can get in our worldwide server - network. Access to all sites is well protected against unauthorized access</p><br><div class='b'>Full cost control</div><p class='thin'>No ongoing subscription, with us you only pay for the product you chose. Risk free and absolutely transparent.</p><br>"];
        $this->update('{{%pages}}', ['content'=>json_encode($contactuspage_data)], ['page_name' => 'contact']);
    }

    public function down()
    {
        echo "m161028_150611_update_pages_contact_page cannot be reverted.\n";

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
