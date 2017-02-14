<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_clicknuploadlink`.
 */
class m160527_131239_create_content_provider_for_clicknuploadlink extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'clicknupload.link',
            'class' => 'service\\components\\ClicknUploadLink',
            'url_tpl' => 'http:\/\/clicknupload\.link\/.+',
            'auth_url' => 'http://clicknupload.link',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('csu6HJ3v9FvjC56', $key)),
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
