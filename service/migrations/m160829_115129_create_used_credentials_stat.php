<?php

use yii\db\Migration;

class m160829_115129_create_used_credentials_stat extends Migration
{
    public function up()
    {
        $this->insert('{{%statistical_data_sets}}', [
            'name' => 'used_credentials',
            'attributes' => 'content_provider_id,content_provider_name,credential_id,user_id,times_used',
            'description' => 'Represents credentials usage (by content class).'
        ]);
        $id = $this->db->getLastInsertId();

        $attributes = [
            [
                'name' => 'content_provider_id',
                'group' => true
            ],
            [
                'name' => 'content_provider_name',
                'group' => true
            ],
            [
                'name' => 'credential_id',
                'group' => true
            ],
            [
                'name' => 'times_used',
                'aggr' => 'SUM'
            ]
        ];

        $this->insert('{{%statistical_indexes}}', [
            'statistical_data_set_id' => $id,
            'name' => 'times_credentials_used',
            'attributes' => serialize($attributes),
            'description' => 'Number of times credential was used.'
        ]);
    }

    public function down()
    {
        echo "m160829_115129_create_used_credentials_stat cannot be reverted.\n";

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
