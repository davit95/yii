<?php

use yii\db\Migration;
use yii\db\Query;

class m160818_134137_add_key_field_price_table extends Migration
{
    public function up()
    {
        $key = $this->addColumn('{{%prices}}', 'key', $this->string());
        $queries = (new Query())->select('id')->from('prices');
        foreach ($queries->each() as $query) {
            \Yii::$app->db->createCommand('UPDATE prices SET `key` = '.$query['id'].' WHERE id = '.$query['id'])->execute();
        }
    }

    public function down()
    {
        $this->dropColumn('{{%prices}}', 'key');
    }
}
