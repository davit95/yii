<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_bitvidsx`.
 */
class m160531_072104_create_content_provider_for_bitvidsx extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'bitvid.sx',
            'class' => 'service\\components\\BitvidSx',
            'url_tpl' => 'http:\/\/(www)?\.bitvid\.sx\/.+',
            'auth_url' => 'http://www.bitvid.sx/login.php?redirect=',
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
        ]);
        $cpId = $this->db->getLastInsertId();

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('Nlfooter83', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('3Jz1JOlFRyhn2YR', $key)),
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
