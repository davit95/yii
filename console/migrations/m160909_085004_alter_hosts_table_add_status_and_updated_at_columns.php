<?php

use yii\db\Migration;
use yii\db\Schema;

class m160909_085004_alter_hosts_table_add_status_and_updated_at_columns extends Migration
{
    public function up()
    {
        $this->addColumn('{{%hosts}}','status' , "ENUM('active', 'inactive') DEFAULT 'active'");
        $this->addColumn('{{%hosts}}', 'updated_at', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%hosts}}', 'status');
        $this->dropColumn('{{%hosts}}', 'updated_at');
    }

}
