<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_cloudsixme`.
 */
class m160602_175237_create_content_provider_for_cloudsixme extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'cloudsix.me',
            'class' => 'service\\components\\CloudSixMe',
            'url_tpl' => 'http:\/\/cloudsix\.me\/.+',
            'auth_url' => 'http://cloudsix.me',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('rebelski', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('ZC&y3URmJtti@PfU', $key)),
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
