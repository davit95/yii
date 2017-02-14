<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_dorauploadcom`.
 */
class m160520_115330_create_content_provider_for_dorauploadcom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'doraupload.com',
            'class' => 'service\\components\\DoraUploadCom',
            'url_tpl' => 'http:\/\/www.doraupload.com\/.+',
            'auth_url' => 'https://www.doraupload.com/',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('nM60dypMQSdD9VW', $key)),
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
