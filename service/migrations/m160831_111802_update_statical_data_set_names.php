<?php

use yii\db\Migration;

class m160831_111802_update_statical_data_set_names extends Migration
{
    public function up()
    {
        $this->update('{{%statistical_data_sets}}', ['name' => 'sended_content_amount', 'description' => 'Represents content amount downloaded(streamed) by user.'], ['name' => 'downloaded_content']);
        $this->update('{{%statistical_indexes}}', ['name' => 'sended_content_amount_by_user', 'description' => 'Total content amount downloaded(streamed) by user.'], ['name' => 'downloaded_content']);
    }

    public function down()
    {
        echo "m160831_111802_update_statical_data_set_names cannot be reverted.\n";

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
