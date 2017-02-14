<?php

use yii\db\Migration;

/**
 * Handles the creation for table `api_credentials`.
 */
class m160913_144641_create_api_credentials_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%api_credentials}}', [
            'id' => $this->primaryKey(),
            'callback_url' => $this->string(),
            'token' => $this->string(),
            'return_url' => $this->string(),
            'param' => $this->string(),
            'send_url' => $this->string()
        ]);

        $this->insert('{{%api_credentials}}', [
            'callback_url' => 'dev.premiumlinkgenerator.com/user/price',
            'token' => '',
            'return_url' => '',
            'param' => 'ref=premiumlinkgenerator',
            'send_url'=>'http://wp.mrpay.io/rbl_mrp_api/order/',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%api_credentials}}');
    }
}
