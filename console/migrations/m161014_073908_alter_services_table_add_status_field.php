<?php

use yii\db\Migration;

class m161014_073908_alter_services_table_add_status_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%services}}', 'status', 'ENUM("ACTIVE", "INACTIVE") NOT NULL');
        $this->update('{{%services}}', ['status' => 'ACTIVE']);
    }

    public function down()
    {
        echo "m161014_073908_alter_services_table_add_status_field cannot be reverted.\n";

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
