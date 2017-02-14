<?php

use yii\db\Migration;

class m161012_163352_seed_access_token_for_admin extends Migration
{
    public function up()
    {
        $token = Yii::$app->security->generateRandomString();
        \Yii::$app->db->createCommand("UPDATE `users` SET `access_token`= '".$token."'WHERE role_id = 2")->execute();
    }

    public function down()
    {
       \Yii::$app->db->createCommand("UPDATE `users` SET `access_token`= '' WHERE role_id = 2")->execute();
    }

}
