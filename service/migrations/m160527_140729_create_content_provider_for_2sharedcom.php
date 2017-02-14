<?php

use yii\db\Migration;

class m160527_140729_create_content_provider_for_2sharedcom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => '2shared.com',
            'class' => 'service\\components\\TwoSharedCom',
            'url_tpl' => 'http:\/\/www\.2shared\.com\/.+',
            'auth_url' => 'http://www.2shared.com/login',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jn.tongko@gmail.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('kY8!L$vUzn*7ID7', $key)),
            'status' => 'ACTIVE'
        ]);
        $cId = $this->db->getLastInsertId();

        $this->insert('{{%content_providers_credentials}}', [
            'content_provider_id' => $cpId,
            'credential_id' => $cId
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        return false;
    }
}
