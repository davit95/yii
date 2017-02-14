<?php

use yii\db\Migration;

class m160429_091339_create_content_provider_for_filespacecom extends Migration
{
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'filespace.com',
            'class' => 'service\\components\\FileSpaceCom',
            'url_tpl' => 'http:\/\/filespace.com\/+',
            'auth_url' => 'http://filespace.com/login.html',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('filehost83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('2Wnumey^$s%7f4M', $key)),
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
