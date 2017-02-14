<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_novafilecom`.
 */
class m160607_113438_create_content_provider_for_novafilecom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'novafile.com',
            'class' => 'service\\components\\NovaFileCom',
            'url_tpl' => 'http:\/\/novafile\.com\/.+',
            'auth_url' => 'http://novafile.com/login',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('6657005', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('8ir2wtarwt', $key)),
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
