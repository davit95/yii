<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_foxuploadonline`.
 */
class m160606_135613_create_content_provider_for_foxuploadonline extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'foxupload.online',
            'class' => 'service\\components\\FoxUploadOnline',
            'url_tpl' => 'https:\/\/foxupload\.online\/.+',
            'auth_url' => 'https://foxupload.online/ajax/_account_login.ajax.php',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('ugHyFrb01XAXBoO', $key)),
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
