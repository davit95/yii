<?php

use yii\db\Migration;

class m160901_065542_update_statistical_data_sets_and_indexes extends Migration
{
    public function up()
    {
        $this->update('{{%statistical_data_sets}}', ['attributes' => 'user_id,bytes_sended'], ['name' => 'sended_content_amount']);
        $this->update('{{%statistical_data_sets}}', ['attributes' => 'user_id,content_link,content_name,content_size'], ['name' => 'sended_content_attrs']);

        $attributes = [
            [
                'name' => 'user_id',
                'group' => true
            ],
            [
                'name' => 'bytes_sended',
                'aggr' => 'SUM'
            ]
        ];

        $this->update('{{%statistical_indexes}}', ['attributes' => 'user_id,bytes_sended'], ['name' => 'sended_content_amount_by_user']);

        $attributes = [
            [
                'name' => 'user_id',
            ],
            [
                'name' => 'content_link',
            ],
            [
                'name' => 'content_name',
            ],
            [
                'name' => 'content_size',
            ]
        ];

        $this->update('{{%statistical_indexes}}', ['attributes' => serialize($attributes)], ['name' => 'sended_content_attrs']);
    }

    public function down()
    {
        echo "m160901_065542_update_statistical_data_sets_and_indexes cannot be reverted.\n";

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
