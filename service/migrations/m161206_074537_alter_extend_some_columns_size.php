<?php

use yii\db\Migration;

class m161206_074537_alter_extend_some_columns_size extends Migration
{
    public function up()
    {
        //Change links table columns
        $this->alterColumn('{{%links}}', 'content_name', $this->string(255)->notNull());
        $this->alterColumn('{{%links}}', 'link', $this->string(500)->notNull());

        //Change stored_contents table columns
        $this->alterColumn('{{%stored_contents}}', 'name', $this->string(255)->notNull());
        $this->alterColumn('{{%stored_contents}}', 'ext_url', $this->string(500)->notNull());

        //Change stored_content_chunks table columns
        $this->alterColumn('{{%stored_content_chunks}}', 'file', $this->string(500)->notNull());

        //Change statistical_data table columns
        $this->alterColumn('{{%statistical_data}}', 'attr_1_val', $this->string(500)->defaultValue(null));
        $this->alterColumn('{{%statistical_data}}', 'attr_2_val', $this->string(500)->defaultValue(null));
        $this->alterColumn('{{%statistical_data}}', 'attr_3_val', $this->string(500)->defaultValue(null));
        $this->alterColumn('{{%statistical_data}}', 'attr_4_val', $this->string(500)->defaultValue(null));
        $this->alterColumn('{{%statistical_data}}', 'attr_5_val', $this->string(500)->defaultValue(null));
    }

    public function down()
    {
        echo "m161206_074537_alter_extend_some_columns_size cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
