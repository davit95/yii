<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_usercloudcom`.
 */
class m160607_064854_create_content_provider_for_usercloudcom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'usercloud.com',
            'class' => 'service\\components\\UserCloudCom',
            'url_tpl' => 'https:\/\/userscloud\.com\/.+',
            'auth_url' => 'https://userscloud.com/',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('bentong99', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('y3UdvgOPDHGWbS5', $key)),
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
