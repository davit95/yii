<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_nosvideocom`.
 */
class m160607_122111_create_content_provider_for_nosvideocom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'nosvideo.com',
            'class' => 'service\\components\\NosVideoCom',
            'url_tpl' => 'http:\/\/(nos\.video|nosvideo\.com)\/.+',
            'auth_url' => 'http://nosvideo.com/ajax/_account_login.ajax.php',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter82', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('1pzZcBmEZ3Lvr68', $key)),
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
