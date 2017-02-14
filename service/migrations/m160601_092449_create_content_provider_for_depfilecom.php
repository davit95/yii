<?php

use yii\db\Migration;

class m160601_092449_create_content_provider_for_depfilecom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'depfile.com',
            'class' => 'service\\components\\DepFileCom',
            'url_tpl' => 'https?:\/\/depfile\.com\/.+',
            'auth_url' => 'https://depfile.com',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('XMOy8FtqUFl5tFm', $key)),
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
