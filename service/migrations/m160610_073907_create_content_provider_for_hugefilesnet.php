<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_hugefilesnet`.
 */
class m160610_073907_create_content_provider_for_hugefilesnet extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'hugefiles.net',
            'class' => 'service\\components\\HugeFilesNet',
            'url_tpl' => 'http:\/\/hugefiles\.net\/.+',
            'auth_url' => 'http://hugefiles.net',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter82', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('swkW9CZt9dCWzK4', $key)),
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
