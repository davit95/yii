<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_mediafirecom`.
 */
class m160603_122910_create_content_provider_for_mediafirecom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'mediafire.com',
            'class' => 'service\\components\\MediaFireCom',
            'url_tpl' => 'http:\/\/(www)?\.mediafire\.com\/download\/.+',
            'auth_url' => 'https://www.mediafire.com',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('administratie@rebelinternet.nl', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('qM1%U8bA6$SaJ6gu', $key)),
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
