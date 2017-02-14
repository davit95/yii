<?php

use yii\db\Migration;

class m160505_155329_create_content_provider_for_rarfileNet extends Migration
{
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'wwww.rarefile.net',
            'class' => 'service\\components\\RareFileNet',
            'url_tpl' => 'http:\/\/www.rarefile.net\/+',
            'auth_url' => 'http://www.rarefile.net/login.html',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('merry345', $key)),
            'status' => 'ACTIVE'
        ]);
        $cId = $this->db->getLastInsertId();

        $this->insert('{{%content_providers_credentials}}', [
            'content_provider_id' => $cpId,
            'credential_id' => $cId
        ]);
    }

    public function down()
    {
        return false;
    }
}
