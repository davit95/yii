<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_tusfilesnet`.
 */
class m160525_140436_create_content_provider_for_tusfilesnet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'tusfiles.net',
            'class' => 'service\\components\\TusFilesNet',
            'url_tpl' => 'http(s)?:\/\/tusfiles\.net\/.+',
            'auth_url' => 'https://tusfiles.net',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('Aqve$F%P0w&!3Wj', $key)),
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
        $this->dropTable('content_provider_for_tusfilesnet');
    }
}
