<?php

use yii\db\Migration;

class m160426_184220_alter_hosts_add_limit_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%hosts}}', 'limit', $this->integer(10)->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%hosts}}','limit');
    }
}
