<?php

use yii\db\Migration;

class m161130_115425_alter_table_pages_drop_content_column extends Migration
{
    public function up()
    {
        //$this->dropColumn('{{%pages}}', 'content');
        $this->addColumn('{{%pages}}', 'title',$this->string()->notNull());

        Yii::$app->db->createCommand()->batchInsert("{{%pages}}", ['page_name'], [
            ['login'],
            ['register'],
            ['profile'],
            ['download'],
            ['credits'],
            ['referral'],
            ['transaction'],
            ['forum'],
            ['my-downloads'],
            ['overviews'],
            ['order'],
            ['supported-payment-methods']
        ])->execute();
    }

    public function down()
    {
       $this->addColumn('{{%pages}}', 'pages',$this->text());
    }

}
