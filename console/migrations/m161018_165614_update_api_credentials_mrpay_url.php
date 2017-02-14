<?php

use yii\db\Migration;

class m161018_165614_update_api_credentials_mrpay_url extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand("UPDATE `api_credentials` SET `send_url`= 'https://mrpay.io/rbl_mrp_api/order/'")->execute();
    }

    public function down()
    {
        \Yii::$app->db->createCommand("UPDATE `api_credentials` SET `send_url`= 'http://wp.mrpay.io/rbl_mrp_api/order/'")->execute();
    }

}
