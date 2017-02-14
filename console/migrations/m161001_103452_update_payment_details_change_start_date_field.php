<?php

use yii\db\Migration;

class m161001_103452_update_payment_details_change_start_date_field extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand('ALTER TABLE  `payment_details` MODIFY COLUMN  `start_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP')->execute();
    }

    public function down()
    {
        \Yii::$app->db->createCommand('ALTER TABLE  `payment_details` MODIFY COLUMN  `start_date` integer NOT NULL')->execute();
    }

}
