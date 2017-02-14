<?php

use yii\db\Migration;

class m160907_094320_alter_content_providers_add_updated_at_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%content_providers}}', 'updated_at', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%content_providers}}', 'updated_at');
    }
}
