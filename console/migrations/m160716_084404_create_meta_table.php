<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `meta_table`.
 */
class m160716_084404_create_meta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%meta}}', [
            'id' => $this->primaryKey(),
            'page_id'=> $this->integer()->notNull(),
            'name'=>$this->string()->notNull(),
            'content'=>$this->string()->notNull(),
        ]);
        $this->addForeignKey('fk_meta_page_id', '{{%meta}}', 'page_id', '{{%pages}}', 'id', 'CASCADE','RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_meta_page_id',"{{%meta}}");
        $this->dropTable('{{%meta}}');
    }
}
