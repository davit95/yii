<?php

use yii\db\Migration;
use yii\db\Query;

class m161215_100901_update_rarfile_host_name extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand("UPDATE hosts SET name=:value1 WHERE name=:name ")
        ->bindValue(':value1', 'rarefile.net')
        ->bindValue(':name',"www.rarefile.net")
        ->execute();
    }

    public function down()
    {
        echo "m161215_100901_update_rarfile_host_name cannot be reverted.\n";

        return false;
    }
}
