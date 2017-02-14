<?php

use yii\db\Migration;

class m161103_142840_update_credentials extends Migration
{
    public function up()
    {
        $key = 'iET1IM1GYh';

        //1fichier.com
        $host = '1fichier.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('e7R6h1h&yU7QYPU', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //filefactory.com
        $host = 'filefactory.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('U3u3uEyU5w6qEht', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //ulozto.net
        $host = 'ulozto.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('ulT3@IHfG6^pBH', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);
    }

    public function down()
    {
        echo "m161103_142840_update_credentials cannot be reverted.\n";

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
