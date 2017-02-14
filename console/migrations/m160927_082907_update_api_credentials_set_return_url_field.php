<?php

use yii\db\Migration;
use yii\db\Query;

class m160927_082907_update_api_credentials_set_return_url_field extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand("UPDATE `api_credentials` SET `return_url`= 'http://dev.premiumlinkgenerator.com/en/price',`callback_url`= 'http://dev.premiumlinkgenerator.com/v1_api/payment/get-response'")->execute();
    }

    public function down()
    {
        \Yii::$app->db->createCommand("UPDATE `api_credentials` SET `return_url`= '',`callback_url`= 'dev.premiumlinkgenerator.com/v1_api/payment/get-response'")->execute();
    }

}
