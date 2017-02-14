<?php

use yii\db\Migration;

class m160610_103154_add_email_field_prices_table extends Migration
{
    public function up()
    {
         $this->addColumn('{{%payments}}', 'email', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%payments}}', 'email');
    }

}
