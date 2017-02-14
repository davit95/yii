<?php

use yii\db\Migration;

class m160713_095113_alter_services_table_add_api_url extends Migration
{
    public function up()
    {
        $this->addColumn('{{%services}}', 'api_url', $this->string(200)->notNull());

        $this->execute('UPDATE {{%services}} SET `url` =  TRIM(TRAILING "/" FROM `url`)');
        $this->execute('UPDATE {{%services}} SET `api_url` =  CONCAT(`url`, "/api")');
    }

    public function down()
    {
        echo "m160713_095113_alter_services_table_add_api_url cannot be reverted.\n";

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
