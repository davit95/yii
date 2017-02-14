<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_rapidfilesharenet`.
 */
class m160601_152108_create_content_provider_for_rapidfilesharenet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'rapidfileshare.net',
            'class' => 'service\\components\\RapidFileShareNet',
            'url_tpl' => 'http:\/\/(www)?\.rapidfileshare\.net\\/.+',
            'auth_url' => 'http://www.rapidfileshare.net/',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('E5lnKUd2yBLRxOW', $key)),
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
