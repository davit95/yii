<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_alfafilenet`.
 */
class m160524_113333_create_content_provider_for_alfafilenet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'alfafile.net',
            'class' => 'service\\components\\AlfaFileNet',
            'url_tpl' => 'http:\/\/alfafile\.net\/.+',
            'auth_url' => 'http://alfafile.net/user/login/?url=%2F',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('q1VfaFgFKNqn5S9', $key)),
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
