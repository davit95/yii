<?php

use yii\db\Migration;

class m160506_070921_alter_links_add_password_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%links}}', 'password', $this->string(20).' AFTER link');
    }

    public function down()
    {
        echo "m160506_070921_alter_links_add_password_column cannot be reverted.\n";

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
