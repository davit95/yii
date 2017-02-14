<?php

use yii\db\Migration;

class m161018_131601_update_statistical_data_sets_add_attrs extends Migration
{
    public function up()
    {
        $this->update('{{%statistical_data_sets}}', ['attributes' => 'user_id,bytes_sended,provider_id,provider_name'], ['name' => 'sended_content_amount']);
    }

    public function down()
    {
        echo "m161018_131601_update_statistical_data_sets_add_attrs cannot be reverted.\n";

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
