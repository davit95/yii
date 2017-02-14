<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_secureuploadeu`.
 */
class m160531_075703_create_content_provider_for_secureuploadeu extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'secureupload.eu',
            'class' => 'service\\components\\SecureUploadEu',
            'url_tpl' => 'http(s)?:\/\/(www)?\.secureupload\.eu\/.+',
            'auth_url' => 'https://secureupload.eu',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('pX8wTL097rpvLUa', $key)),
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
