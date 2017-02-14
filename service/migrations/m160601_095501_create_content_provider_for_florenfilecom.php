<?php

use yii\db\Migration;

class m160601_095501_create_content_provider_for_florenfilecom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'florenfile.com',
            'class' => 'service\\components\\FlorenFileCom',
            'url_tpl' => 'http:\/\/florenfile\.com\/.+',
            'auth_url' => 'http://florenfile.com',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('BIO9E7sF5bEOyWR', $key)),
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
