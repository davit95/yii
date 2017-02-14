<?php

use yii\db\Migration;
use yii\db\Schema;
use Carbon\Carbon;

/**
 * Handles the creation for table `api_users`.
 */
class m160914_122435_create_api_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%api_users}}', [
            'id' => $this->primaryKey(),
            'token' => $this->string(),
            'refresh_token' => $this->string(),
            'expiration_date' => $this->string(),
            'expire' => "ENUM('expired', 'no_expired') DEFAULT 'no_expired'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%api_users}}');
    }
}
