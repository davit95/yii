<?php

use yii\db\Migration;

class m161003_130229_update_payment_details_table_add_updated_at_default_value extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand("ALTER TABLE  `payment_details` MODIFY COLUMN  `updated_at` integer NULL DEFAULT NULL")->execute();
    }

    public function down()
    {
       \Yii::$app->db->createCommand("ALTER TABLE  `payment_details` MODIFY COLUMN  `updated_at` integer")->execute();
    }

}
