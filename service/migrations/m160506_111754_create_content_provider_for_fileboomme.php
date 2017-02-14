<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_fileboomme`.
 */
class m160506_111754_create_content_provider_for_fileboomme extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'fboom.me',
            'class' => 'service\\components\\FileBoomMe',
            'url_tpl' => 'http:\/\/fboom.me\/+',
            'auth_url' => 'http://fboom.me/login.html',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('qR5g&gJHN5iG#m^', $key)),
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
