<?php

use yii\db\Migration;

class m160923_082215_alter_api_credentials_table_add_integration_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%api_credentials}}', 'integration', $this->string());

        \Yii::$app->db->createCommand("UPDATE `api_credentials` SET `integration`= 'premiumlinkgenerator'")->execute();
    }

    public function down()
    {
         $this->dropColumn('{{%api_credentials}}', 'integration');
    }
}
