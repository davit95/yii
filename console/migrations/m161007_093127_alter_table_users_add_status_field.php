<?php

use yii\db\Migration;

class m161007_093127_alter_table_users_add_status_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'plan_status', $this->string()->notNull()->defaultValue('inactive'));
    }

    public function down()
    {
        $this->dropColumn('{{%user_orders}}', 'status');
    }

}
