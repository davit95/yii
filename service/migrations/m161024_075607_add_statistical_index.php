<?php

use yii\db\Migration;

class m161024_075607_add_statistical_index extends Migration
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
            ]
        ];

        $this->insert('{{%statistical_indexes}}', [
            'statistical_data_set_id' => 1,
            'name' => 'sended_content_amount_per_provider_by_user',
            'attributes' => serialize($attributes),
            'description' => 'Total content amount downloaded(streamed) per provider by user.'
        ]);
    }

    public function down()
    {
        echo "m161024_075607_add_statistical_index cannot be reverted.\n";

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
