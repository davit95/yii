<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_nitroflarecom`.
 */
class m160603_084021_create_content_provider_for_nitroflarecom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'nitroflare.com',
            'class' => 'service\\components\\NitroFlareCom',
            'url_tpl' => 'http:\/\/nitroflare\.com\/.+',
            'auth_url' => 'https://nitroflare.com/login',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('x1T5Y9SeUWFYX8l', $key)),
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
