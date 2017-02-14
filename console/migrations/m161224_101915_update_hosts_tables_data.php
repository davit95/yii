<?php

use yii\db\Migration;

class m161224_101915_update_hosts_tables_data extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand("UPDATE hosts SET max_mb_per_day=:value1 WHERE name=:name ")
        ->bindValue(':value1', '20 Gb')
        ->bindValue(':name',"depfile.com")
        ->execute();
    }

    public function down()
    {
        \Yii::$app->db->createCommand("UPDATE hosts SET max_mb_per_day=:value1 WHERE name=:name ")
        ->bindValue(':value1', '20 Gb')
        ->bindValue(':name',"depfile.com")
        ->execute();
    }

}
