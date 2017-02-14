<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_shareonlinebiz`.
 */
class m160607_083543_create_content_provider_for_shareonlinebiz extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'share-online.biz',
            'class' => 'service\\components\\ShareOnlineBiz',
            'url_tpl' => 'http:\/\/(www)?\.share-online\.biz\/.+',
            'auth_url' => 'https://www.share-online.biz/user/login',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('OZqkO0Mun', $key)),
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
