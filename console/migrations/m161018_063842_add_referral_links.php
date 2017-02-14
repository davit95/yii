<?php

use yii\db\Migration;
use yii\db\Query;

class m161018_063842_add_referral_links extends Migration
{
    public function up()
    {
        $query = new Query();
        $query->from('{{%referral_links}}');

        if ($query->count() == 0) {
            $this->insert('{{%referral_links}}', [
                'name' => 'Direct link 1',
                'type' => 'DIRECT',
                'template' => 'http://premiumlinkgenerator.com/?uid={uid}&lid={lid}'
            ]);
            $this->insert('{{%referral_links}}', [
                'name' => 'Forum link 1',
                'type' => 'PHPBBFORUM',
                'template' => '[URL=http://premiumlinkgenerator.com/?uid={uid}&lid={lid}]Premiumlinkgenerator.com[/URL]'
            ]);
            $this->insert('{{%referral_links}}', [
                'name' => 'Image link',
                'type' => 'IMAGE',
                'template' => '<a href="http://premiumlinkgenerator.com/?uid={uid}&lid={lid}"><img src="http://plg.local/data/referral/offer.png"></a>'
            ]);
        }
    }

    public function down()
    {
        echo "m161018_063842_add_referral_links cannot be reverted.\n";

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
