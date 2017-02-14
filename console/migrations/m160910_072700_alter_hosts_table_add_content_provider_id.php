<?php

use yii\db\Migration;
use yii\db\Query;

class m160910_072700_alter_hosts_table_add_content_provider_id extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand(" UPDATE hosts SET name=:value1 WHERE id=:id ")
        ->bindValue(':value1', 'nosvideo.com')
        ->bindValue(':id',9)
        ->execute();
        \Yii::$app->db->createCommand(" UPDATE content_providers SET name=:value1 WHERE id=:id ")
        ->bindValue(':value1', 'www.rarefile.net')
        ->bindValue(':id',6)
        ->execute();

        $content_provider_id = $this->addColumn('{{%hosts}}', 'content_provider_id', $this->integer());

        $queries_hosts = (new Query())->select('name')->from('hosts');

        $queries_content_providers = (new Query())->select('name,id')->from('content_providers');
        foreach ($queries_content_providers->each() as $query) {
            \Yii::$app->db->createCommand('UPDATE hosts SET `content_provider_id` = '.$query['id'].' WHERE name = "'.$query["name"].'"')->execute();
        }


    }

    public function down()
    {
         $this->dropColumn('{{%hosts}}', 'content_provider_id');
    }

}
