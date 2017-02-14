<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_anafilecom`.
 */
class m160530_135833_create_content_provider_for_anafilecom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'anafile.com',
            'class' => 'service\\components\\AnaFileCom',
            'url_tpl' => 'http:\/\/(www)?\.anafile\.com\/.+',
            'auth_url' => 'http://www.anafile.com',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('CJI2vHmzM0jy5Qq', $key)),
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
