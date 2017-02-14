<?php

use yii\db\Migration;

class m160518_094447_update_content_providers_credentials extends Migration
{
    public function up()
    {
        /**
         * According to message from Benjie
         *
         * interfile.net Nlfooter83 rW12bYmLMKPJ00r
         * limefile.com Nlfooter83 KQz3bFD6x3420Fv
         * rarefile.net Nlfooter83 qV90Bl8BnNkwq9m
         * uplea.com Nlfooter83 n6Fw5uOn0uzSaRz
         * uptobox.com Nlfooter83 Skiqe0bbwjMBCqv
         * depositfiles.com Nlfooter83 if6Y6JYu7CMggSy
         * filefactory.com jaap.schoon@aol.com OcFdU2D1O2NePxt
         * nitroflare.com jaap.schoon@aol.com 86LwTO7Vn0AX
         * rockfile.eu Nlfooter83 HKz5ZqN96dbNC6F
         * sendspace.com jaap.schoon@aol.com qOW5pJugvaHk1BM
         * speedyshare.com Nlfooter83 bQ36cLgNhEYXkh3
         * uloz.to Nlfooter83 chfZID8dINh54ga
         * salefiles.com Nlfooter83 vygO1VtQZg2Vgc5
         * subyshare.com Nlfooter83 4jNPaW77QDx4veH
         * zippyshare.com Nlfooter83 pn^3Nj^b@e035jS
         */

        $key = 'iET1IM1GYh';

        //interfile.net
        $host = 'interfile.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('rW12bYmLMKPJ00r', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //limefile.com
        $host = 'limefile.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('KQz3bFD6x3420Fv', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //rarefile.net
        $host = 'rarefile.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('qV90Bl8BnNkwq9m', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //uplea.com
        $host = 'uplea.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('n6Fw5uOn0uzSaRz', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //uptobox.com
        $host = 'uptobox.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('Skiqe0bbwjMBCqv', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //depositfiles.com
        $host = 'depositfiles.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('if6Y6JYu7CMggSy', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //filefactory.com
        $host = 'filefactory.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('OcFdU2D1O2NePxt', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //nitroflare.com
        $host = 'nitroflare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('86LwTO7Vn0AX', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //rockfile.eu
        $host = 'rockfile.eu';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('HKz5ZqN96dbNC6F', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //sendspace.com
        $host = 'sendspace.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('qOW5pJugvaHk1BM', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //speedyshare.com
        $host = 'speedyshare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('bQ36cLgNhEYXkh3', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //uloz.to
        $host = 'uloz.to';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('chfZID8dINh54ga', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //salefiles.com
        $host = 'salefiles.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('vygO1VtQZg2Vgc5', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //subyshare.com
        $host = 'subyshare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('4jNPaW77QDx4veH', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //zippyshare.com
        $host = 'zippyshare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('pn^3Nj^b@e035jS', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);
    }

    public function down()
    {
        echo "m160518_094447_update_content_providers_credentials cannot be reverted.\n";

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
