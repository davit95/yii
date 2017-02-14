<?php

use yii\db\Migration;

class m160905_133306_update_statistical_index extends Migration
{
    public function up()
    {
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

        $this->update('{{%statistical_indexes}}', ['attributes' => serialize($attributes)], ['name' => 'sended_content_amount_by_user']);
    }

    public function down()
    {
        echo "m160905_133306_update_statistical_index cannot be reverted.\n";

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
