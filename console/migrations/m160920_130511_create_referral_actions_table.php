<?php

use yii\db\Migration;

/**
 * Handles the creation for table `referral_actions`.
 */
class m160920_130511_create_referral_actions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%referral_actions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'description' => $this->string(255)->notNull(),
            'points' => $this->smallInteger(6)->notNull(),
            'status' => 'ENUM("ACTIVE","INACTIVE") NOT NULL'
        ]);

        $this->createIndex('idx_referral_actions_name' , '{{%referral_actions}}', 'name', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%referral_actions}}');
    }
}
