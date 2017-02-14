<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_fileloadio
 */
class m160609_065652_create_content_provider_for_fileloadio extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'fileload.io',
            'class' => 'service\\components\\FileLoadIo',
            'url_tpl' => 'https:\/\/fileload\.io\/.+',
            'auth_url' => 'https://api.fileload.io/login',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jn.tongko@gmail.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('eElem5dKdUNVQxG', $key)),
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
