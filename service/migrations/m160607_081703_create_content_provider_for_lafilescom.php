<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_lafilescom`.
 */
class m160607_081703_create_content_provider_for_lafilescom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'lafiles.com',
            'class' => 'service\\components\\LafilesCom',
            'url_tpl' => 'http:\/\/lafiles\.com\/.+',
            'auth_url' => 'http://lafiles.com/',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter82', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('R57CmraBbouX3hA', $key)),
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
