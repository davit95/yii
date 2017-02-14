<?php

use yii\db\Migration;

class m160616_105016_update_payments_table extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%payments}}', 'pm_id');
    }

    public function down()
    {
        $this->addColumn('{{%payments}}', 'pm_id', $this->string());
    }
}
