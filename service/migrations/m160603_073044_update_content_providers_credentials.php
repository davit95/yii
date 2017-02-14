<?php

use yii\db\Migration;

class m160603_073044_update_content_providers_credentials extends Migration
{
    public function up()
    {
        /**
         * According to message from Benjie
         *
         * interfile.net Nlfooter83 HNwvW6TppvxH82q
         * 2shared.com jn.tongko@gmail.com zH0RnDhUCfpKQu1
         * bigfile.to Nlfooter83 9Opw4WWBMRuohH5
         * daofile.com Nlfooter83 3a6gYHXfjWQCxPc
         * depositfiles.com Nlfooter83 Th3e9ReEp7S6amQ
         * filefactory.com jaap.schoon@aol.com U3u3uEyU5w6qEht
         * florenfile.com Nlfooter83 Gih3krKnueJDY30
         * nitroflare.com jaap.schoon@aol.com x1T5Y9SeUWFYX8l
         * sendspace.com jaap.schoon@aol.com t0f2HBRc3HC5X7w
         * uloz.to Nlfooter83 9ZAkdkyHX0b0mpC
         * datafile.com jaap.schoon@aol.com pvNS6jAfHDb8zou
         * hitfile.net jaap.schoon@aol.com gxGt3ygryIGUm2g
         * rapidgator.net jaap.schoon@aol.com Ig2KzbxRVClMNNF
         * zippyshare.com Nlfooter83 d1XzBH2U4ksOfTa
         * rapidrar.com Nlfooter83 Jnsyk1D8M9Smt4X
         * turbobit.net jaap.schoon@aol.com zS2X2jZ5es5d1c8
         * multiupload.biz Nlfooter83 4gTQV1qNkI5PtVQ
         * redbunker.net Nlfooter83 C0YsK9xPGvgP6en
         * wushare.com Nlfooter83 yheQB28LeQEdzJx
         * zbigz.com jaap.schoon@aol.com 4hv9QMVi7553EDH
         * openload.co jaap.schoon@aol.com ExEut4v7ClVi5Pm
         * depfile.com jaap.schoon@aol.com MQFXd6LOZC448vj
         * megacache.net Nlfooter83 fiBolQ5uNcZLCku
         * wipfiles.net Nlfooter83 RKwV9dP1817o@ZV
         * keep2share.cc jaap.schoon@aol.com K5uekWzQb3nQ9Ce
         */

        $key = 'iET1IM1GYh';

        //interfile.net
        $host = 'interfile.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('HNwvW6TppvxH82q', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //2shared.com
        $host = '2shared.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jn.tongko@gmail.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('zH0RnDhUCfpKQu1', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //bigfile.to
        $host = 'bigfile.to';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('9Opw4WWBMRuohH5', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //daofile.com
        $host = 'daofile.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('3a6gYHXfjWQCxPc', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //depositfiles.com
        $host = 'depositfiles.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('Th3e9ReEp7S6amQ', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //filefactory.com
        $host = 'filefactory.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('U3u3uEyU5w6qEht', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //florenfile.com
        $host = 'florenfile.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('Gih3krKnueJDY30', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //nitroflare.com
        $host = 'nitroflare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('x1T5Y9SeUWFYX8l', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //sendspace.com
        $host = 'sendspace.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('t0f2HBRc3HC5X7w', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //uloz.to
        $host = 'uloz.to';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('9ZAkdkyHX0b0mpC', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //datafile.com
        $host = 'datafile.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('pvNS6jAfHDb8zou', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //hitfile.net
        $host = 'hitfile.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('gxGt3ygryIGUm2g', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //rapidgator.net
        $host = 'rapidgator.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('Ig2KzbxRVClMNNF', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //zippyshare.com
        $host = 'zippyshare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('d1XzBH2U4ksOfTa', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //rapidrar.com
        $host = 'rapidrar.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('Jnsyk1D8M9Smt4X', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //turbobit.net
        $host = 'turbobit.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('zS2X2jZ5es5d1c8', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //multiupload.biz
        $host = 'multiupload.biz';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('4gTQV1qNkI5PtVQ', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //redbunker.net
        $host = 'redbunker.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('C0YsK9xPGvgP6en', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //wushare.com
        $host = 'wushare.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('yheQB28LeQEdzJx', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //zbigz.com
        $host = 'zbigz.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('4hv9QMVi7553EDH', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //openload.co
        $host = 'openload.co';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('ExEut4v7ClVi5Pm', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //depfile.com
        $host = 'depfile.com';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('MQFXd6LOZC448vj', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //megacache.net
        $host = 'megacache.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('fiBolQ5uNcZLCku', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //wipfiles.net
        $host = 'wipfiles.net';
        $user = utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('RKwV9dP1817o@ZV', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);

        //keep2share.cc
        $host = 'keep2share.cc';
        $user = utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key));
        $pass = utf8_encode(Yii::$app->security->encryptByKey('K5uekWzQb3nQ9Ce', $key));
        $this->execute("UPDATE credentials LEFT JOIN content_providers_credentials ON (credentials.id = content_providers_credentials.credential_id) LEFT JOIN content_providers ON (content_providers_credentials.content_provider_id = content_providers.id) SET user = :user, pass = :pass WHERE content_providers.name = :host", [':user' => $user, ':pass' => $pass, ':host' => $host]);
    }

    public function down()
    {
        echo "m160603_073044_update_content_providers_credentials cannot be reverted.\n";

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
