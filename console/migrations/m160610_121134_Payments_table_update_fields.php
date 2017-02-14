<?php

use yii\db\Migration;

class m160610_121134_Payments_table_update_fields extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%payments}}', 'created_at');
        $this->dropColumn('{{%payments}}', 'updated_at');
    }

    public function down()
    {
        $this->addColumn('{{%payments}}', 'created_at', $this->integer()->notNull());
        $this->addColumn('{{%payments}}', 'updated_at', $this->integer()->notNull());
    }

}
