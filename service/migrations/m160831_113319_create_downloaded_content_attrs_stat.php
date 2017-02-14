<?php

use yii\db\Migration;

class m160831_113319_create_downloaded_content_attrs_stat extends Migration
{
    public function up()
    {
        $this->insert('{{%statistical_data_sets}}', [
            'name' => 'sended_content_attrs',
            'attributes' => 'user_id,link,name,size',
            'description' => 'Represents downoladed(streamed) content attributes (user id,link,name,size).'
        ]);
        $id = $this->db->getLastInsertId();

        $attributes = [
            [
                'name' => 'user_id',
            ],
            [
                'name' => 'link',
            ],
            [
                'name' => 'name',
            ],
            [
                'name' => 'size',
            ]
        ];

        $this->insert('{{%statistical_indexes}}', [
            'statistical_data_set_id' => $id,
            'name' => 'sended_content_attrs',
            'attributes' => serialize($attributes),
            'description' => 'Downoladed(streamed) content attributes (user id,link,name,size).'
        ]);
    }

    public function down()
    {
        echo "m160831_113319_create_downloaded_content_attrs_stat cannot be reverted.\n";

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
