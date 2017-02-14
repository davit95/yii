<?php

use yii\db\Migration;
use yii\db\Schema;

class m160615_130003_add_fields_payments_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%payments}}', 'pm_id', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%payments}}', 'description', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%payments}}', 'pm_id');
        $this->dropColumn('{{%payments}}', 'description');
    }
}
