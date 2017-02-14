<?php

use yii\db\Migration;

class m161216_125635_update_refferal_links extends Migration
{
    public function up()
    {
        $this->update('{{referral_links}}', [
            'template' => '<a href="http://premiumlinkgenerator.com/?uid={uid}&lid={lid}"><img src="http://premiumlinkgenerator.com/data/referral/offer.png"></a>'
        ], ['name' => 'Image link']);
    }

    public function down()
    {
        echo "m161216_125635_update_refferal_links cannot be reverted.\n";

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
