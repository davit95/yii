<?php

use yii\db\Migration;

class m160823_135241_add_fields_users_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'start_date', $this->integer()->notNull());
        $this->addColumn('{{%users}}', 'period', $this->string());
        $this->addColumn('{{%users}}', 'limit', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%users}}', 'start_date');
        $this->dropColumn('{{%users}}', 'period');
        $this->dropColumn('{{%users}}', 'limit');
    }
}
