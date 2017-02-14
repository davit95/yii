<?php

use yii\db\Migration;

class m161024_113106_update_statistical_index extends Migration
{
    public function up()
    {
        $attributes = [
            [
                'name' => 'provider_id',
                'group' => true
            ],
            [
                'name' => 'provider_name',
                'group' => true
            ],
            [
                'name' => 'user_id',
                'group' => true
            ],
            [
                'name' => 'bytes_sended',
                'aggr' => 'SUM'
            ],
            [
                'name' => 'timestamp',
                'aggr' => 'MIN',
                'alias' => 'from'
            ],
            [
                'name' => 'timestamp',
                'aggr' => 'MAX',
                'alias' => 'to'                
            ]

        ];

        $this->update('{{%statistical_indexes}}', ['attributes' => serialize($attributes)], ['name' => 'sended_content_amount_per_provider_by_user']);
    }

    public function down()
    {
        echo "m161024_113106_update_statistical_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
