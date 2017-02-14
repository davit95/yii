<?php

use yii\db\Migration;

/**
 * Handles the creation for table `users_plans`.
 */
class m161123_072316_create_users_plans_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%users_plans}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'type' => 'ENUM("DAILY", "LIMITED") NOT NULL',
            'start' => $this->integer(11)->notNull(),
            'expire' => $this->integer(11)->defaultValue(null),
            'days' => $this->integer(10)->defaultValue(null),
            'limit' => $this->integer(10)->defaultValue(null),
            'status' => 'ENUM("ACTIVE", "INACTIVE", "EXPIRED") NOT NULL'
        ]);

        $this->addForeignKey('fk_users_plans_user_id', '{{%users_plans}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users_plans');
    }
}
