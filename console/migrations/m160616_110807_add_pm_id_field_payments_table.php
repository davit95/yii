<?php

use yii\db\Migration;

class m160616_110807_add_pm_id_field_payments_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%payments}}', 'pm_id', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%payments}}', 'pm_id');
    }

}
