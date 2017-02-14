<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_junocloudme`.
 */
class m160610_080704_create_content_provider_for_junocloudme extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'junocloud.me',
            'class' => 'service\\components\\JunoCloudMe',
            'url_tpl' => 'http:\/\/(dl\d+\.)?junocloud\.me\/.+',
            'auth_url' => 'http://junocloud.me',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter82', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('lG2WuKaVhXYeAGX', $key)),
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
