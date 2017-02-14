<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_speedysharecom`.
 */
class m160516_163116_create_content_provider_for_speedysharecom extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'speedyshare.com',
            'class' => 'service\\components\\SpeedyShareCom',
            'url_tpl' => 'http:\/\/www.speedyshare.com\/+',
            'auth_url' => 'https://www.speedyshare.com/login.php',
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
