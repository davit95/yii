<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_provider_for_meganz`.
 */
class m160615_111950_create_content_provider_for_meganz extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%content_providers}}', [
            'name' => 'mega.nz',
            'class' => 'service\\components\\MegaNz',
            'url_tpl' => 'https:\/\/mega\.nz\/#![a-zA-Z0-9_]+![a-zA-Z0-9_]+',
            'auth_url' => null,
            'downloadable' => 1,
            'streamable' => 0,
            'storable' => 0,
            'status' => 'ACTIVE'
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
