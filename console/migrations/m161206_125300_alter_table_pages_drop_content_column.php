<?php

use yii\db\Migration;

class m161206_125300_alter_table_pages_drop_content_column extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%pages}}', 'content');
    }

    public function down()
    {
        $this->addColumn('{{%pages}}', 'content',$this->string());
    }

}
