<?php

use yii\db\Migration;

class m161107_150201_update_contact_us_context extends Migration
{
    public function up()
    {
        $contactuspage_data = [
        'Title1'=>'Contact Us','Title2'=>'Values we stand for','div1Title'=>'Real and secure privacy','div1'=>'Are you often out, surfing in cafes, railway stations or airports? Thats an invitation for data thieves. Save your networks, your identity, bank and credit card data. All Internet connections are encrypted using up to 256-bit - so no one will get your data.','div2Title'=>'Absolutely reliable','div2'=>"We don’t know cheapy, just low cost for value! While selecting our infrastructure, we look for the highest quality you can get in our worldwide server - network. Access to all sites is well protected against unauthorized access",'div3Title'=>'Full cost control','div3'=>'No ongoing subscription, with us you only pay for the product you chose. Risk free and absolutely transparent.'];
        $this->update('{{%pages}}', ['content'=>json_encode($contactuspage_data)], ['page_name' => 'contact']);
    }

    public function down()
    {
        echo "m161028_150611_update_pages_contact_page cannot be reverted.\n";

        return false;
    }
}
