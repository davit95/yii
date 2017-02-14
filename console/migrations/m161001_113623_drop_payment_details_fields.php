<?php

use yii\db\Migration;

class m161001_113623_drop_payment_details_fields extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%payment_details}}', 'pm_id');
        $this->dropColumn('{{%payment_details}}', 'target_niche');
    }

    public function down()
    {
        $this->addColumn('{{%payment_details}}', 'pm_id', $this->string());
        $this->addColumn('{{%payment_details}}', 'target_niche', $this->string());
    }
}
