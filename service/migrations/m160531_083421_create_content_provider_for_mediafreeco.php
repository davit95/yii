<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_mediafreeco`.
 */
class m160531_083421_create_content_provider_for_mediafreeco extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'mediafree.co',
            'class' => 'service\\components\\MediaFreeCo',
            'url_tpl' => 'http:\/\/mediafree\.co\/.+',
            'auth_url' => 'http://mediafree.co',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('ls120Ef5ZPlv1Pm', $key)),
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
