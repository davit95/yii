<?php

use yii\db\Migration;

class m161031_120007_update_credentials extends Migration
{
    public function up()
    {
        $key = 'iET1IM1GYh';

        //zippyshare.com
        $host = 'zippyshare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('d1XzBH2U4ksOfTa', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);
    }

    public function down()
    {
        echo "m161031_120007_update_credentials cannot be reverted.\n";

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
