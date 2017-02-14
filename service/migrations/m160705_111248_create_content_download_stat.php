<?php

use yii\db\Migration;

/**
 * Handles the creation for table `content_download_stat`.
 */
class m160705_111248_create_content_download_stat extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->insert('{{%statistical_data_sets}}', [
            'name' => 'downloaded_content',
            'attributes' => 'user_id,bytes',
            'description' => 'Represents content amount downloaded by user.'
        ]);
        $id = $this->db->getLastInsertId();

        $attributes = [
            [
                'name' => 'user_id',
                'group' => true
            ],
            [
                'name' => 'bytes',
                'aggr' => 'SUM'
            ]
        ];

        $this->insert('{{%statistical_indexes}}', [
            'statistical_data_set_id' => $id,
            'name' => 'downloaded_content',
            'attributes' => serialize($attributes),
            'description' => 'Total content amount downloaded by user.'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('content_download_stat');
    }
}
