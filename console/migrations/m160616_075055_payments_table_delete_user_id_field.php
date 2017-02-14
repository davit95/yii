<?php

use yii\db\Migration;
use yii\db\Schema;

class m160616_075055_payments_table_delete_user_id_field extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%payments}}', 'user_id');
    }

    public function down()
    {
        $this->addColumn('{{%payments}}', 'user_id', Schema::TYPE_INTEGER . ' NOT NULL');
    }

}
