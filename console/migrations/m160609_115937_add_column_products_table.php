<?php

use yii\db\Migration;

class m160609_115937_add_column_products_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%prices}}', 'description', $this->string(200));
    }

    public function down()
    {
        $this->dropColumn('{{%prices}}', 'description');
    }

}
