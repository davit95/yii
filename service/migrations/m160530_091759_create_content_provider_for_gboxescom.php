<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_gboxescom`.
 */
class m160530_091759_create_content_provider_for_gboxescom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'gboxes.com',
            'class' => 'service\\components\\GboxesCom',
            'url_tpl' => 'http:\/\/(www)?\.gboxes\.com\/.+',
            'auth_url' => 'http://www.gboxes.com',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('XTmEbvxRTn56e4d', $key)),
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
