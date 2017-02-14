<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_upstorenet`.
 */
class m160602_073706_create_content_provider_for_upstorenet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'upstore.net',
            'class' => 'service\\components\\UpstoreNet',
            'url_tpl' => 'http:\/\/upsto(\.re|re\.net)\/.+',
            'auth_url' => 'http://upstore.net/account/login',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('wNWZgqsf', $key)),
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
