<?php

use yii\db\Migration;

class m160826_132353_update_admin_password extends Migration
{
    public function up()
    {
        $this->update('users', array(
            'password_hash' => Yii::$app->security->generatePasswordHash('AsKjq^huW%as')),'role_id=2'
        );
    }

    public function down()
    {
        $this->update('users', array(
            'password_hash' => Yii::$app->security->generatePasswordHash('admin')),'role_id=2'
        );
    }

}
