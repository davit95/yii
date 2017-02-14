<?php

use yii\db\Migration;

/**
 * Handles the creation for table `logs`.
 */
class m160919_092323_create_logs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%logs}}', [
            'id' => $this->bigPrimaryKey(),
            'level' => $this->integer(),
            'category' => $this->string(),
            'log_time' => $this->double(),
            'prefix' => $this->text(),
            'message' => $this->text(),
        ]);

        $this->createIndex('idx_logs_level', '{{%logs}}', 'level');
        $this->createIndex('idx_logs_category', '{{%logs}}', 'category');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%logs}}');
    }
}
