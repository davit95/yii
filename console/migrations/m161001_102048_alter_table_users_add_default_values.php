<?php

use yii\db\Migration;

class m161001_102048_alter_table_users_add_default_values extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand("ALTER TABLE  `users` MODIFY COLUMN  `start_date` TIMESTAMP NULL DEFAULT NULL")->execute();
    }

    public function down()
    {
         \Yii::$app->db->createCommand('ALTER TABLE  `users` MODIFY COLUMN  `start_date` integer NOT NULL')->execute();
    }

}
