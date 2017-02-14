<?php

use yii\db\Migration;

class m161014_065438_update_users_table_set_access_token_where_empty extends Migration
{
    public function up()
    {
        $this->update('{{%users}}',
            ['access_token' => \Yii::$app->security->generateRandomString(16)],
            ['or', ['access_token' => null], ['access_token' => '']]
        );
    }

    public function down()
    {
        echo "m161014_065438_update_users_table_set_access_token_where_empty cannot be reverted.\n";

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
