<?php

use yii\db\Migration;

class m160530_150852_create_content_provider_for_hitfilenet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'hitfile.net',
            'class' => 'service\\components\\HitFileNet',
            'url_tpl' => 'http:\/\/hitfile\.net\/.+',
            'auth_url' => 'http://hitfile.net/user/login',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('nm34f8OtSagxGAq', $key)),
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
