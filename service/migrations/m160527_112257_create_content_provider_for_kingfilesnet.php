<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_kingfilesnet`.
 */
class m160527_112257_create_content_provider_for_kingfilesnet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'kingfiles.net',
            'class' => 'service\\components\\KingFilesNet',
            'url_tpl' => 'http:\/\/kingfiles\.net\/.+',
            'auth_url' => 'http://kingfiles.net/ajax/_account_login.ajax.php',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('21DGyoYU9OKukj1', $key)),
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
        $this->dropTable('content_provider_for_kingfilesnet');
    }
}
