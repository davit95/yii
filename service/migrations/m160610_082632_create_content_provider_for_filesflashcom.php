<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_filesflashcom`.
 */
class m160610_082632_create_content_provider_for_filesflashcom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'filesflash.com',
            'class' => 'service\\components\\FilesFlashCom',
            'url_tpl' => 'http:\/\/filesflash\.com\/.+',
            'auth_url' => 'http://filesflash.com/login.php',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jn.tongko@gmail.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('z81dkpo1', $key)),
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
