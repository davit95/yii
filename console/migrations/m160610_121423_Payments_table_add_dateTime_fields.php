<?php

use yii\db\Migration;
use yii\db\Schema;

class m160610_121423_Payments_table_add_dateTime_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%payments}}', 'created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%payments}}', 'updated_at', Schema::TYPE_INTEGER . ' NOT NULL');
    } 
    public function down()
    {
        $this->dropColumn('{{%payments}}', 'created_at');
        $this->dropColumn('{{%payments}}', 'updated_at');
    }

}
