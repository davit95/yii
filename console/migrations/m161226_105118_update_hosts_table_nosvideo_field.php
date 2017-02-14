<?php

use yii\db\Migration;

class m161226_105118_update_hosts_table_nosvideo_field extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand("UPDATE hosts SET host_url=:url WHERE name=:name ")
        ->bindValue(':url', 'http://nosvideo.com/')
        ->bindValue(':name',"nosvideo.com")
        ->execute();
    }

    public function down()
    {
         \Yii::$app->db->createCommand("UPDATE hosts SET host_url=:url WHERE name=:name ")
        ->bindValue(':url', 'http://novafile.com/')
        ->bindValue(':name',"nosvideo.com")
        ->execute();
    }

}
