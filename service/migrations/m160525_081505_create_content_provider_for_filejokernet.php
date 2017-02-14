<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_filejokernet`.
 */
class m160525_081505_create_content_provider_for_filejokernet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'filejoker.net',
            'class' => 'service\\components\\FileJokerNet',
            'url_tpl' => 'http(s)?:\/\/filejoker\.net\/.+',
            'auth_url' => 'https://filejoker.net/login',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('jsUtTIVg15lquqO', $key)),
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
