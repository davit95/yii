<?php

use yii\db\Migration;

class m160505_115442_create_content_provider_for_interfilenet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'interfile.net',
            'class' => 'service\\components\\InterfileNet',
            'url_tpl' => 'http:\/\/interfile\.net\/.+',
            'auth_url' => 'http://interfile.net/?op=login',
            'downloadable' => 1,
            'streamable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('jaap2016', $key)),
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
